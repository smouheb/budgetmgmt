
<?php
//appel bd
$bdd = new PDO('mysql:host=localhost;dbname=money_mgmt','root','root');
$selectdata = $bdd->Query('SELECT * FROM money_movement 
					ORDER BY date_post DESC LIMIT 0, 10');
// selectionner les derniers credits

$selectcredit = $bdd->Query('SELECT * FROM money_movement WHERE type = "Credit" ORDER BY date_post DESC');

// selectionner les debits

$selectdebit = $bdd->Query('SELECT * FROM money_movement WHERE type = "Debit" ORDER BY date_post DESC');

//selection la sum des credits

$sumcredit = $bdd->Query('SELECT SUM(amount) AS sum_credit, type FROM money_movement WHERE type = "Credit" GROUP BY type');

//selection de la sum des debits

$sumdebit = $bdd->Query('SELECT SUM(amount) AS sum_debit, type FROM money_movement WHERE type = "Debit" GROUP BY type ');

?>
<!DOCTYPE html>
<html>
<!---Dashboard-->
    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Dashboard</title>
    </head>
    <body>
        <h1>Monthly Budget</h1>
        <form method="POST" action="model.php">
            <h3>Enter any movement or any expense</h3>
            <p>
            <div class="form-group">
                <label> Name: 
                    <select class="" name="type">
                            <option name="empty_type"></option>
                            <option name="Credit">Credit</option>
                            <option name="Debit">Debit</option>
                    </select>
                </label>
            </p>
            <p>
                <label>Name:
                    <select name="c_name">
                            <option name="empty_name"></option>
                            <option name="salary">Salary</option>
                            <option name="cns">CNS</option>
                            <option name="bill">Bill</option>
                            <option name="ccns">CNS</option>
                            <option name="cother">Other Crebit</option>
                            <option name="dother">Other Debit</option>
                    </select>
                </label>
            </p>
            <p><label>Amount: <input type="texte" name="amount"></label></p>
            <p><label>Date: <input type="date" name="date_movement"></label></p>
            <p><label>Comment: <textarea row="6" col="50" name="comment"></textarea></label></p>	
            <button type="submit" name="send" class="btn btn-default">Submit</button>

            </div>
        </form>
        <br>
        <div class="selectionentries"><strong>Here are the last entries on the accounts from:</strong>
            <?php
                while($dataselected = $selectdata->fetch())
                {
                    echo $dataselected['name']." of ".$dataselected['amount']." the ".$dataselected['date_movement']."<br>";
                }	
            ?>
        </div>
        <br>
        <div class="selectioncredit"> <strong>Here are the credits:</strong>
            <?php 
                while($datacredit = $selectcredit->fetch())
                {
                    echo $datacredit['name']." of ".$datacredit['amount']." the ".$datacredit['date_movement']."<br>";
                }	
            ?>
        </div>
        <br>
        <div class="selectiondebit"><strong>Here are the debits:</strong>
            <?php 
                while($datadebit = $selectdebit->fetch())
                {
                    echo $datadebit['name']." of ".$datadebit['amount']." the ".$datadebit['date_movement']."<br>";
                }	
            ?>
        </div>
        <br>
        <div><strong>Sum of all credit entries:</strong>
            <?php while($datasumcred = $sumcredit->fetch())
                {
                    echo $datasumcred['type']." ---->".$datasumcred['sum_credit'];
                    $_GLOBAL['sum_credit'] = $datasumcred['sum_credit'];
                }
            ?>
        </div>
        <br>
        <div><strong>Sum of all debit entries:</strong>
            <?php 
                while($datasumdeb = $sumdebit->fetch())
                {
                    echo $datasumdeb['type']." ---->".$datasumdeb['sum_debit'];
                    $_GLOBAL['sum_debit'] = $datasumdeb['sum_debit'];

                }
            ?>
        </div>
        <div>
            <?php 
                $moneyleft = $_GLOBAL['sum_credit'] - $_GLOBAL['sum_debit'];
                echo "This is what is left on the account: "." ".$moneyleft;
            ?>
        </div>
    </body>
</html>
