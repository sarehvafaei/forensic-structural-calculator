from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
from scipy import stats
import os
from functools import wraps
import jwt

app = Flask(__name__)
CORS(app)

# Configuration
SECRET_KEY = os.environ.get('JWT_SECRET_KEY', 'your-secret-key')  # Replace in production

def token_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token = request.headers.get('Authorization')
        if not token:
            return jsonify({'message': 'Token is missing'}), 401
        try:
            jwt.decode(token.split()[1], SECRET_KEY, algorithms=["HS256"])
        except:
            return jsonify({'message': 'Invalid token'}), 401
        return f(*args, **kwargs)
    return decorated

class StructuralCalculator:
    @staticmethod
    def calculate_beam_deflection(length, load, elastic_modulus, moment_of_inertia):
        """Calculate maximum deflection of a simply supported beam"""
        try:
            # Convert inputs to float and validate
            length = float(length)
            load = float(load)
            elastic_modulus = float(elastic_modulus)
            moment_of_inertia = float(moment_of_inertia)
            
            # Maximum deflection formula: (5wL^4)/(384EI)
            deflection = (5 * load * (length ** 4)) / (384 * elastic_modulus * moment_of_inertia)
            return deflection
        except ValueError:
            raise ValueError("Invalid input parameters")

    @staticmethod
    def calculate_stress_analysis(force, area, moment, section_modulus):
        """Calculate combined normal and bending stress"""
        try:
            force = float(force)
            area = float(area)
            moment = float(moment)
            section_modulus = float(section_modulus)
            
            normal_stress = force / area
            bending_stress = moment / section_modulus
            combined_stress = normal_stress + bending_stress
            return {
                'normal_stress': normal_stress,
                'bending_stress': bending_stress,
                'combined_stress': combined_stress
            }
        except ValueError:
            raise ValueError("Invalid input parameters")

    @staticmethod
    def calculate_crack_width(steel_stress, cover, area_ratio):
        """Calculate crack width in concrete structures"""
        try:
            steel_stress = float(steel_stress)
            cover = float(cover)
            area_ratio = float(area_ratio)
            
            # Simplified Gergely-Lutz equation
            crack_coefficient = 0.076
            crack_width = crack_coefficient * steel_stress * (cover * area_ratio) ** (1/3)
            return crack_width
        except ValueError:
            raise ValueError("Invalid input parameters")

@app.route('/api/beam-deflection', methods=['POST'])
@token_required
def beam_deflection():
    try:
        data = request.get_json()
        result = StructuralCalculator.calculate_beam_deflection(
            data['length'],
            data['load'],
            data['elastic_modulus'],
            data['moment_of_inertia']
        )
        return jsonify({'deflection': result})
    except (KeyError, ValueError) as e:
        return jsonify({'error': str(e)}), 400

@app.route('/api/stress-analysis', methods=['POST'])
@token_required
def stress_analysis():
    try:
        data = request.get_json()
        result = StructuralCalculator.calculate_stress_analysis(
            data['force'],
            data['area'],
            data['moment'],
            data['section_modulus']
        )
        return jsonify(result)
    except (KeyError, ValueError) as e:
        return jsonify({'error': str(e)}), 400

@app.route('/api/crack-width', methods=['POST'])
@token_required
def crack_width():
    try:
        data = request.get_json()
        result = StructuralCalculator.calculate_crack_width(
            data['steel_stress'],
            data['cover'],
            data['area_ratio']
        )
        return jsonify({'crack_width': result})
    except (KeyError, ValueError) as e:
        return jsonify({'error': str(e)}), 400

if __name__ == '__main__':
    app.run(debug=False)