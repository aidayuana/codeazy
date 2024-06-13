from flask import Flask, request, jsonify
from flask_cors import CORS
import subprocess
import os
import tempfile
import threading

app = Flask(__name__)
CORS(app)

# Dictionary to store attempts counter for each user and module ID
attempts_counter = {}
# Dictionary to store attempts to success counter for each user and module ID
attempts_to_success = {}
# Dictionary to store failed attempts counter for each user and module ID
failed_attempts = {}
# Dictionary to store whether the last attempt was successful or not
last_attempt_successful = {}
# Lock for thread-safe dictionary operations
lock = threading.Lock()

@app.route('/run', methods=['POST'])
def run_code():
    data = request.json
    code = data.get('code')
    unit_tests = data.get('unitTests')
    modul_id = data.get('modulId')
    user_id = data.get('userId')

    if code is None or unit_tests is None or modul_id is None or user_id is None:
        return jsonify({'error': 'No code, unit tests, module ID, or user ID provided'}), 400

    # Create a unique key for the user-module combination
    key = f"{user_id}_{modul_id}"

    with lock:
        # Initialize the attempts, attempts_to_success, failed_attempts, and last_attempt_successful if not present
        if key not in attempts_counter:
            attempts_counter[key] = 0
        if key not in attempts_to_success:
            attempts_to_success[key] = 0
        if key not in failed_attempts:
            failed_attempts[key] = 0
        if key not in last_attempt_successful:
            last_attempt_successful[key] = False

        # Increment the attempts counter for this user-module combination
        attempts_counter[key] += 1
        # Get the current attempts count for this user-module combination
        attempts = attempts_counter[key]

    # Create a temporary directory to store code and tests
    with tempfile.TemporaryDirectory() as tempdir:
        code_file = os.path.join(tempdir, 'code.py')
        test_file = os.path.join(tempdir, 'test_code.py')

        # Write the code to a file
        with open(code_file, 'w') as f:
            f.write(code)

        # First, run the user's code to check for syntax errors or runtime errors
        result_code = subprocess.run(['python', code_file], capture_output=True, text=True)

        if result_code.returncode != 0:
            # If there are errors in the code, return them and do not run the tests
            return jsonify({
                'code_stdout': result_code.stdout,
                'code_stderr': result_code.stderr,
                'test_stdout': '',
                'test_stderr': '',
                'attempts': attempts,  # Send attempts count in the response
                'attempts_to_success': attempts_to_success.get(key, 0),  # Send attempts to success count in the response
                'failed_attempts': failed_attempts.get(key, 0),  # Send failed attempts count in the response
            })

        # Combine code and tests into one file
        combined_file_content = code + "\n\n" + unit_tests

        # Write the combined code and tests to the test file
        with open(test_file, 'w') as f:
            f.write(combined_file_content)

        # Run the unit tests
        result_tests = subprocess.run(['python', test_file], capture_output=True, text=True)

        with lock:
            if result_tests.returncode == 0:
                # Only update attempts_to_success if the test was successful on the first attempt or after a failure
                if not last_attempt_successful[key]:
                    attempts_to_success[key] = attempts
                last_attempt_successful[key] = True  # Update the last_attempt_successful status
                # Do not reset attempts counter if successful
            else:
                failed_attempts[key] += 1  # Increase failed attempts if the test failed
                last_attempt_successful[key] = False  # Update the last_attempt_successful status

            attempts_to_success_count = attempts_to_success[key]
            failed_attempts_count = failed_attempts[key]

        return jsonify({
            'code_stdout': result_code.stdout,
            'code_stderr': result_code.stderr,
            'test_stdout': result_tests.stdout,
            'test_stderr': result_tests.stderr,
            'attempts': attempts,  # Send attempts count in the response
            'attempts_to_success': attempts_to_success_count,  # Send attempts to success count in the response
            'failed_attempts': failed_attempts_count,  # Send failed attempts count in the response
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
            'code_stderr': '',  # Code errors if needed
            'test_stdout': result.stdout,
            'test_stderr': result.stderr,
        })


@app.route('/reset-attempts', methods=['POST'])
def reset_attempts():
    data = request.json
    modul_id = data.get('modulId')
    user_id = data.get('userId')

    # Create a unique key for the user-module combination
    key = f"{user_id}_{modul_id}"

    with lock:
        # Reset the attempts counter to 0 for the specified user-module combination
        attempts_counter[key] = 0
        attempts_to_success[key] = 0  # Optionally reset the attempts to success counter as well
        failed_attempts[key] = 0  # Reset failed attempts counter as well
        last_attempt_successful[key] = False  # Reset last_attempt_successful status

    return jsonify({'status': 'success', 'message': 'Attempts counter reset to 0'})


if __name__ == '__main__':
    app.run(debug=True)
