from flask import Flask, request, jsonify
from flask_cors import CORS
import subprocess
import os
import tempfile

app = Flask(__name__)
CORS(app)

# Dictionary to store attempts counter for each modul ID
attempts_counter = {}
# Dictionary to store attempts to success counter for each modul ID
attempts_to_success = {}

@app.route('/run', methods=['POST'])
def run_code():
    data = request.json
    code = data.get('code')
    unit_tests = data.get('unitTests')
    modul_id = data.get('modulId')

    if code is None or unit_tests is None or modul_id is None:
        return jsonify({'error': 'No code, unit tests, or modul ID provided'}), 400

    # Get the current attempts count for this modul ID
    attempts = attempts_counter.get(modul_id, 0)
    # Get the current attempts to success count for this modul ID
    attempts_to_success_count = attempts_to_success.get(modul_id, 0)

    # Create a temporary directory to store code and tests
    with tempfile.TemporaryDirectory() as tempdir:
        code_file = os.path.join(tempdir, 'code.py')
        test_file = os.path.join(tempdir, 'test_code.py')

        # Write the code to a file
        with open(code_file, 'w') as f:
            f.write(code)

        # Combine code and tests into one file
        combined_file_content = code + "\n\n" + unit_tests

        # Write the combined code and tests to the test file
        with open(test_file, 'w') as f:
            f.write(combined_file_content)

        # Run the unit tests
        result = subprocess.run(['python', test_file], capture_output=True, text=True)

        if result.returncode == 0:
            # Reset attempts counter if the code execution succeeded
            attempts_counter[modul_id] = 0
            # Update attempts to success counter if it was not zero (meaning it had previous attempts)
            if attempts > 0:
                attempts_to_success[modul_id] = attempts
        else:
            # Increment the attempts counter if the code execution failed
            attempts_counter[modul_id] = attempts + 1

        return jsonify({
            'code_stdout': '',  # Code output if needed
            'code_stderr': '',  # Code errors if needed
            'test_stdout': result.stdout,
            'test_stderr': result.stderr,
            'attempts': attempts_counter[modul_id],  # Send attempts count in the response
            'attempts_to_success': attempts_to_success.get(modul_id, 0)  # Send attempts to success count in the response
        })
        

@app.route('/run-guru', methods=['POST'])
def run_guru():
    data = request.json
    code = data.get('code')
    unit_tests = data.get('unitTests')

    if code is None or unit_tests is None:
        return jsonify({'error': 'No code or unit tests provided'}), 400

    # Create a temporary directory to store code and tests
    with tempfile.TemporaryDirectory() as tempdir:
        code_file = os.path.join(tempdir, 'code.py')
        test_file = os.path.join(tempdir, 'test_code.py')

        # Write the code to a file
        with open(code_file, 'w') as f:
            f.write(code)

        # Combine code and tests into one file
        combined_file_content = code + "\n\n" + unit_tests

        # Write the combined code and tests to the test file
        with open(test_file, 'w') as f:
            f.write(combined_file_content)

        # Run the unit tests
        result = subprocess.run(['python', test_file], capture_output=True, text=True)

        return jsonify({
            'code_stdout': '',  # Code output if needed
            'code_stderr': '',  # Code errors if needed
            'test_stdout': result.stdout,
            'test_stderr': result.stderr,
        })

@app.route('/reset-attempts', methods=['POST'])
def reset_attempts():
    data = request.json
    modul_id = data.get('modulId')

    # Reset the attempts counter to 0 for the specified modul ID
    attempts_counter[modul_id] = 0

    return jsonify({'status': 'success', 'message': 'Attempts counter reset to 0'})

if __name__ == '__main__':
    app.run(debug=True)
