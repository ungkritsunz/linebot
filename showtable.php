<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);			
$conn = new mysqli($server, $username, $password, $db);
$sql = "SELECT id, ask, ans FROM detail";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
            echo '<table class="table-bordered">';
            echo '<tbody>';
                while ($row = $result->fetch_object()) {
                    echo '<tr>';
                        echo '<td>'.$row["ask"].'</td><td>'.$row["ans"]."</td>";
                    echo '</tr>';
                }
            echo '</tbody></table>';
            $result->close();
        }        
?>