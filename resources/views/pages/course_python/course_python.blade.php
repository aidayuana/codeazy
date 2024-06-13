@extends('layouts.master')

@section('main')
<div class="content-wrapper">
  <div class="row">
    <div class="container">
      <div class="row">
        <!-- Embed file section -->
        <div class="col-md-4">
          <embed src="{{ asset('storage/modul/' . $data->nama) }}" type="application/pdf" width="100%" height="700px">
        </div>
        <!-- Editor section -->
        <div class="col-md-8">
          <div>
            <div id="editor" style="height: 500px; width: 100%;">{{ $data->kode_program }}</div>
          </div>
          <div style="display: none">
            <h4>Unit Tests</h4>
            <div id="unitTestsEditor" style="height: 300px; width: 100%;">{{ $data->kunci_jawaban }}</div>
          </div>
          <button id="run-button" class="btn btn-primary mt-3">Run Code</button>
          <div class="mt-2">
            <h4>Output</h4>
            <pre id="output"></pre>
            <pre id="attempts-info"></pre> <!-- Element to display the attempts counter -->
          </div>
        </div>
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
  const userId = {{ Auth::user()->id }}; // Get the user ID

  document.getElementById("run-button").addEventListener("click", function() {
    runCode(modulId, userId);
  });

  async function runCode(modulId, userId) {
    const code = editor.getValue();
    const unitTests = unitTestsEditor.getValue();

    try {
      const response = await fetch("http://localhost:5000/run", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ code, unitTests, modulId, userId }), // Include userId here
      });

      const result = await response.json();

      if (response.ok) {
        document.getElementById("output").textContent =
          // "CODE STDOUT:\n" +
          // (result.code_stdout || "No output") +
          "\nCODE STDERR:\n" +
          (result.code_stderr || "No errors") +
          "\n\nUNIT TEST STDOUT:\n" +
          (result.test_stdout || "No output");
          // "\nUNIT TEST STDERR:\n" +
          // (result.test_stderr || "No errors");

        document.getElementById("attempts-info").textContent =
          "\nCompile Attempts Code: " + result.attempts +
          "\nCode Pass Attempts: " + result.attempts_to_success +
          "\nFailed Code Attempts: " + result.failed_attempts;
      } else {
        document.getElementById("output").textContent =
          "Error: " + result.error;
      }
    } catch (error) {
      document.getElementById("output").textContent =
        "Request failed: " + error;
    }
  }
});
</script>
@endsection
