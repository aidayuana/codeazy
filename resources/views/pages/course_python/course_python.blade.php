@extends('layouts.master')

@section('main')
<div class="title">Python Editor</div>
<div class="content-wrapper">
  <div class="row">
    <div class="container">
      <div>
          <div id="editor" style="height: 300px; width: 100%;">{{ $data->kode_program }}</div>
      </div>
      <div style="display: none">
          <h4>Unit Tests</h4>
          <div id="unitTestsEditor" style="height: 300px; width: 100%;">{{ $data->kunci_jawaban }}</div>
      </div>
      <button id="run-button" class="btn btn-primary mt-3" onclick="runCode()">Run Code</button>
      <div class="mt-2">
          <h4>Output</h4>
          <pre id="output"></pre>
          <p id="attempts-info"></p> <!-- Element to display the attempts counter -->
      </div>
    </div>
  </div>
</div>

{{-- Script required for code editor --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.13/ace.js" type="text/javascript" charset="utf-8"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const editor = ace.edit("editor");
  editor.setTheme("ace/theme/monokai");
  editor.session.setMode("ace/mode/python");

  const unitTestsEditor = ace.edit("unitTestsEditor");
  unitTestsEditor.setTheme("ace/theme/monokai");
  unitTestsEditor.session.setMode("ace/mode/python");

  const modulId = {{ $data->id }}; // Ensure this is correctly passing the modul ID

  document.getElementById("run-button").addEventListener("click", function() {
    runCode(modulId);
  });

  async function runCode(modulId) {
    const code = editor.getValue();
    const unitTests = unitTestsEditor.getValue();

    try {
      const response = await fetch("http://localhost:5000/run", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ code, unitTests, modulId }), // Include modulId here
      });

      const result = await response.json();

      if (response.ok) {
        document.getElementById("output").textContent =
          // "CODE STDOUT:\n" +
          // (result.code_stdout || "No output") +
          // "\nCODE STDERR:\n" +
          // (result.code_stderr || "No errors") +
          "\n\nUNIT TEST STDOUT:\n" +
          (result.test_stdout || "No output") +
          "\nUNIT TEST STDERR:\n" +
          (result.test_stderr || "No errors") +
          "\nATTEMPTS:" +
          result.attempts +
          "\nATTEMPTS TO SUCCESS:" +
          result.attempts_to_success;
      } else {
        document.getElementById("output").textContent =
          "Error: " + result.error;
      }
    } catch (error) {
      document.getElementById("output").textContent =
        "Fetch Error: " + error.message;
    }
  }
});



async function resetAttempts(modulId) {
  try {
    const response = await fetch("http://localhost:5000/reset-attempts", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ modulId }),
    });

    const result = await response.json();

    if (response.ok) {
      alert(result.message || "Attempts counter reset successfully!");
    } else {
      alert("Error: " + (result.message || "An error occurred"));
    }
  } catch (error) {
    alert("Fetch Error: " + error.message);
  }
}

</script>
@endsection
