<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Electricity Calculator</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(to right, #69cbe2ff, #0f738cff);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .calculator-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 500px;
    }
    .result-card {
      background-color: #f0f8ff;
      border-left: 5px solid #167e98ff;
      border-radius: 12px;
    }
    .btn-custom {
      background-color: #136a80ff;
      border: none;
    }
    .btn-custom:hover {
      background-color: #1a5b72ff;
    }
  </style>
</head>
<body>

<div class="calculator-card">
  <h3 class="text-center mb-4 text-primary"><i class="fas fa-bolt"></i> Electricity Calculator</h3>

  <form method="POST">
    <div class="form-group">
      <label for="voltage">Voltage <small>(V)</small></label>
      <input type="number" step="any" class="form-control" name="voltage" id="voltage" required>
    </div>
    
    <div class="form-group">
      <label for="current">Current <small>(A)</small></label>
      <input type="number" step="any" class="form-control" name="current" id="current" required>
    </div>

    <div class="form-group">
      <label for="rate">Electricity Rate <small>(sen/kWh)</small></label>
      <input type="number" step="any" class="form-control" name="rate" id="rate" required>
    </div>

    <button type="submit" class="btn btn-custom btn-block text-white">Calculate</button>
  </form>

  <?php
  function calculateElectricity($voltage, $current, $rate, $hours) {
      $power = $voltage * $current; // in watts
      $energy = ($power * $hours) / 1000; // in kWh
      $total = $energy * ($rate / 100); // in RM
      return ['power' => $power, 'energy' => $energy, 'total' => $total];
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $voltage = floatval($_POST['voltage']);
      $current = floatval($_POST['current']);
      $rate = floatval($_POST['rate']);

      $hourly = calculateElectricity($voltage, $current, $rate, 1);
      $daily = calculateElectricity($voltage, $current, $rate, 24);

      echo '
      <div class="result-card mt-4 p-3">
        <h5 class="text-primary"><i class="fas fa-chart-line"></i> Results</h5>
        <table class="table mt-3">
          <thead class="thead-light">
            <tr>
              <th>Parameter</th>
              <th>Per Hour</th>
              <th>Per Day</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Power</td>
              <td>' . number_format($hourly["power"], 2) . ' W</td>
              <td>' . number_format($daily["power"], 2) . ' W</td>
            </tr>
            <tr>
              <td>Energy</td>
              <td>' . number_format($hourly["energy"], 4) . ' kWh</td>
              <td>' . number_format($daily["energy"], 4) . ' kWh</td>
            </tr>
            <tr>
              <td>Charge</td>
              <td>RM ' . number_format($hourly["total"], 4) . '</td>
              <td>RM ' . number_format($daily["total"], 4) . '</td>
            </tr>
          </tbody>
        </table>
      </div>';
  }
  ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
