<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
</head>
<body>

    <form action="{{ route('check.variable') }}" method="POST">
        @csrf
        <label for="key">Enter Key:</label>
        <input type="text" id="key" name="key" required>
        <button type="submit">Verify</button>
    </form> 
</body>
</html>
