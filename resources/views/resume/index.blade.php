<!DOCTYPE html>
  <html>
  <head>
      <title>Resume Analyzer</title>
  </head>
  <body>
      <h1>Upload Resume</h1>
      <form action="{{ route('resume.analyze') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="resume" accept=".txt,.pdf,.doc,.docx" required>
          <textarea name="job_description" required></textarea>
          <button type="submit">Analyze</button>
      </form>
  </body>
  </html>
