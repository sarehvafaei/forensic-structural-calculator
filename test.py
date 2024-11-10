import requests

url = "http://127.0.0.1:5000/calculate"
headers = {"Content-Type": "application/json"}
data = {"force": 10, "distance": 5}

response = requests.post(url, json=data, headers=headers)

print("Status Code:", response.status_code)
print("Response JSON:", response.json())
