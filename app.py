from flask import Flask, request, jsonify
import numpy as np

app = Flask(__name__)

@app.route('/calculate', methods=['POST'])
def calculate():
    data = request.json
    force = data.get('force', 0)
    distance = data.get('distance', 0)
    # Example calculation: bending moment
    bending_moment = force * distance
    return jsonify({'bending_moment': bending_moment})

if __name__ == '__main__':
    app.run(debug=True)
