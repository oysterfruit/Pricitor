<!--get grid data and format it-->
        <?php require 'PricitorDB.php';

          //find all the retailers that service the selected resort

          $sql = "SELECT id, name FROM resort";
          $result = $conn->query($sql);
          $options = "";
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $options .= "<option value = " . $row["id"]. ">" . $row["name"]. "</option>";
                }
                echo $options;
            } else {
                echo "no resorts found";
            }
             $conn->close();
        ?> <!--end php -->