<!DOCTYPE html>
<html>
<head>
    <title>Calendário</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
        // Obtém o número do mês e do ano atual
        $month = date('m');
        $year = date('Y');
        
        // Cria um objeto DateTime para o primeiro dia do mês
        $firstDay = new DateTime("{$year}-{$month}-01");
        
        // Obtém o número de dias no mês atual
        $numDays = $firstDay->format('t');
        
        // Obtém o nome do mês atual
        $monthName = $firstDay->format('F');
        
        // Obtém o dia da semana em que o primeiro dia do mês cai
        $firstDayOfWeek = $firstDay->format('N');
    ?>

    <h2><?php echo $monthName . ' ' . $year; ?></h2>
    <table>
        <tr>
            <th>Domingo</th>
            <th>Segunda</th>
            <th>Terça</th>
            <th>Quarta</th>
            <th>Quinta</th>
            <th>Sexta</th>
            <th>Sábado</th>
        </tr>
        <tr>
            <?php
                // Adiciona células vazias para os dias antes do primeiro dia da semana
                for ($i = 1; $i < $firstDayOfWeek; $i++) {
                    echo '<td></td>';
                }
                
                // Loop para exibir os dias do mês
                for ($day = 1; $day <= $numDays; $day++) {
                    // Verifica se é domingo (dia 7) para iniciar uma nova linha
                    if ($firstDayOfWeek > 7) {
                        echo '</tr><tr>';
                        $firstDayOfWeek = 1;
                    }
                    
                    echo "<td>{$day}</td>";
                    
                    $firstDayOfWeek++;
                }
                
                // Adiciona células vazias para os dias após o último dia do mês
                while ($firstDayOfWeek <= 7) {
                    echo '<td></td>';
                    $firstDayOfWeek++;
                }
            ?>
        </tr>
    </table>
</body>
</html>
