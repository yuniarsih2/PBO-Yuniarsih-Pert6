<!DOCTYPE html>
<html>

<head>
    <title>Kalkulator Suhu</title>
</head>

<body>
    <h1>Kalkulator Suhu</h1>
    <form method="post">
        <label>Masukkan Suhu (Angka):</label>
        <input type="text" name="input_suhu" required>
        <select name="from_unit">
            <option value="celsius">Celcius</option>
            <option value="kelvin">Kelvin</option>
            <option value="fahrenheit">Fahrenheit</option>
            <option value="reamur">Réaumur</option>
        </select>
        <span>ke</span>
        <select name="to_unit">
            <option value="celsius">Celcius</option>
            <option value="kelvin">Kelvin</option>
            <option value="fahrenheit">Fahrenheit</option>
            <option value="reamur">Réaumur</option>
        </select>
        <input type="submit" name="submit" value="Konversi">
    </form>

    <?php
    class SuhuConverter
    {
        private $konversi;

        public function __construct() // penggunaan untuk memanggil objek SuhuConverter 
        {
            $this->konversi = [
                'celsius' => ['kelvin' => 273.15, 'fahrenheit' => [9 / 5, 32], 'reamur' => 0.8],
                'kelvin' => ['celsius' => -273.15, 'fahrenheit' => [9 / 5, 32], 'reamur' => [-218.52, 5 / 4]],
                'fahrenheit' => ['celsius' => [5 / 9, -32 * 5 / 9], 'kelvin' => [5 / 9, -32 * 5 / 9 + 273.15], 'reamur' => [-173.6, 4 / 9]],
                'reamur' => ['celsius' => 1.25, 'kelvin' => [4 / 5, 109.725], 'fahrenheit' => [9 / 4, 229.95]],
            ];
        }

        public function konversiSuhu($input_suhu, $from_unit, $to_unit) // untuk melakukan perhitungan konversi suhu dari satu unit suhu ke unit suhu lainnya
        {
            $result = $input_suhu;

            // Looping untuk menghitung konversi suhu
            while ($from_unit !== $to_unit) {
                $conversion_factors = $this->konversi[$from_unit][$to_unit];
                if (is_array($conversion_factors)) {
                    $result = $result * $conversion_factors[0] + $conversion_factors[1];
                } else {
                    $result = $result * $conversion_factors;
                }

                // Ubah unit awal menjadi unit tujuan untuk iterasi selanjutnya
                $from_unit = $to_unit;
            }

            return $result;
        }
    }

    if (isset($_POST['submit'])) {
        $input_suhu = floatval($_POST['input_suhu']);
        $from_unit = $_POST['from_unit'];
        $to_unit = $_POST['to_unit'];

        $converter = new SuhuConverter();
        $hasil_konversi = $converter->konversiSuhu($input_suhu, $from_unit, $to_unit);

        echo "<h2>Hasil Konversi:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Dari</th><th>Ke</th><th>Hasil</th></tr>";
        echo "<tr>";
        echo "<td>$from_unit</td>";
        echo "<td>$to_unit</td>";
        echo "<td>$hasil_konversi</td>";
        echo "</tr>";
        echo "</table>";
    }
    ?>
</body>

</html>