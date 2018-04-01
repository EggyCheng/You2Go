#!flask/bin/python
from flask import Flask, jsonify, request
from You2GO import getMusic

app = Flask(__name__)

tasks = [
    {
        'msg': u'done'
    }
]

@app.route('/download', methods=['GET', 'POST'])
def get_tasks():
    print (request.args['key'])
    getMusic(request.args['key'])
    return jsonify({'tasks': tasks})

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
