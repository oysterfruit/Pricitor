<!--standard table headers 01 June to 30 Sep-->
<?php

 // Start date

 $season_start_date = getSeasonStartDate();

 // End date
 $season_end_date = getSeasonEndDate();

//temp date to position the highlighted cells centrally - tricky when near the start of the season
$temp_date = date_add(date_create($season_start_date), date_interval_create_from_date_string("7 days"));
$temp_date = $temp_date->format("Y-m-d");

//variables to store first hidden cols each side of visible cols and the total num of cols in the grid.
//Also storing the colid of the selected dates to highlight the cheapest row as this is done usiing jQuery
//These are output to hidden divs underneath the grid so that they can be read
//by jquery previous and next button functions
$left_col_hidden= $right_col_hidden= $total_cols_hidden= $selected_col_start= $selected_col_end='';

$days_diff_str = "";

switch ($days) {
    case "1":
    case "2":
        $days_diff_str = "-6 days";
        break;
    case "3":
    case "4":
        $days_diff_str = "-5 days";
        break;
    case "5":
    case "6":
        $days_diff_str = "-4 days";
        break;
    case "7":
    case "8":
        $days_diff_str = "-3 days";
        break;
    case "9":
    case "10":
        $days_diff_str = "-2 days";
        break;
    case "11":
    case "12":
        $days_diff_str = "-1 days";
}

if ($days_diff_str != ""){
  $active_page_start= date("Y-m-d", strtotime($days_diff_str, strtotime($startdate)));
  if (strtotime($active_page_start) < strtotime($startdate)){
    $active_page_start = $startdate;
  }

}
else{
  $active_page_start = $startdate;
}

$active_page_end = date("Y-m-d", strtotime("+13 days", strtotime($active_page_start)));

//get end of holiday date for column highlighting (done by cell)
$end_date_str = "+" . $days -1 . " days";
$duration_end = date("Y-m-d", strtotime($end_date_str, strtotime($startdate)));


//set up table headers
  $table_headers = "<thead><tr><th class='col-fixed-160'>Retailer</th><th>Total</th><th></th>";
  $loop_date = $season_start_date;
  $i=1;

  while (strtotime($loop_date) <= strtotime($season_end_date)) {
     $day_name =  Date("D", strtotime($loop_date));
     $mon_name =  Date("M", strtotime($loop_date));
     $day_digit = Date("d", strtotime($loop_date));
     $col_name = "tcol" . strval($i);

     $table_headers = $table_headers . "<th name=" . $col_name;
    if (strtotime($loop_date) < strtotime($active_page_start) || (strtotime($loop_date) > strtotime($active_page_end))){

       $table_headers = $table_headers . " class='myHide center_cell'";
     }
     else
     {
       if (strtotime($loop_date) >= strtotime($startdate) && strtotime($loop_date) <= strtotime($duration_end)){
         $table_headers = $table_headers . " class='highlight_days center_cell'";

         //store the col id's of the start and end cols of the chosen dates
         if (strtotime($loop_date) == strtotime($startdate)){
           $selected_col_start = $i;
         }

        if (strtotime($loop_date) >= strtotime($duration_end)){
          $selected_col_end = $i;
        }

       }
       else
       {
         $table_headers = $table_headers . " class='center_cell'";
       }
     }

    if (strtotime($loop_date) == strtotime($active_page_start)){
      $left_col_hidden = $i-1;
    }
    if (strtotime($loop_date) == strtotime($active_page_end)){
      $right_col_hidden = $i+1;
    }
    if (strtotime($loop_date) == strtotime($season_end_date)){
      $total_cols_hidden = $i;
    }



     $table_headers = $table_headers . ">" . $day_name . "<br>" . $mon_name . "<br> " . $day_digit. "</th>";

     $loop_date = date ("Y-m-d", strtotime("+1 day", strtotime($loop_date)));
      $i=$i+1;
 }
 $table_headers = $table_headers . "</tr></thead>";
 echo $table_headers;




//get grid data and format it
 require 'PricitorDB.php';

  //find all the retailers that service the selected resort

  $sql = "SELECT DISTINCT retailer.name, retailer.weblink, resort_retailer.retailer_id FROM retailer, resort_retailer WHERE resort_retailer.retailer_id = retailer.id and resort_retailer.resort_id = " . $resort;
  $result = $conn->query($sql);
  $table_data = $str_total= $str_retailer= $str_weblink= $str_gobutton= $retailer_name= $str_row= $cheapest_row= $price_startdate= $price_enddate="";
  if ($result->num_rows > 0) {

    $table_data = "<tbody>";
    // loop through retailers and get prices for the selected package, create row in grid
    $lowest_price = 0;
    $price = 0;
    $cheapest_row = 1;
    while($row = $result->fetch_assoc()) {
      $str_weblink = $row["weblink"];
      $str_gobutton = "<td><a href='" . $str_weblink . "' target='_blank' role='button' class='btn btn-go'><i class='fa fa-shopping-cart' aria-hidden='true'></i></a></td>";
      $retailer_name = $row["name"];
      $retailer_id = $row["retailer_id"];
      $sql2 = "SELECT Start_date, End_Date, Price FROM price WHERE retailer_id = " . $retailer_id . " AND package_id = " . $package . " AND Days = " . $days;

      $result2 = $conn->query($sql2);

      if ($result2->num_rows > 0) {
          //load the prices returned into an array
          $price_array = array();
          while($temp = $result2->fetch_assoc()){  //load the dataset into an array
               $price_array[] = $temp;
          }
          //echo '<pre>'; var_dump($price_array);
          $loop_date = $season_start_date;
          $str_total = "";
          $str_row = "";

        $i=1; //column counter
        //loop through each day in the season and find the correct price for that retailer for that package for that day, construct the row.
        while (strtotime($loop_date) <= strtotime($season_end_date)){
          $col_name = "tcol" . strval($i);
          $str_row = $str_row . "<td name=" . $col_name;

          //set price to n/a if no price found for that date
          $price = "n/a";
          $j = 0; //array counter
          for ($j = 0; $j < count($price_array); $j++) {
            $price_startdate = $price_array[$j]['Start_date'];
            $price_enddate = $price_array[$j]['End_Date'];
            if (strtotime($loop_date) >= strtotime($price_startdate) && strtotime($loop_date) <= strtotime($price_enddate)) {
              $price = $price_array[$j]['Price'];
                     break;
            }
          }//end for loop

          //work out whether to show or hide this column
          if (strtotime($loop_date) < strtotime($active_page_start) || (strtotime($loop_date) > strtotime($active_page_end)))
            {
              $str_row = $str_row . " class='myHide center_cell'"; //cell off screen so hide it
            }
            else
           { //if the current cell is during the selected holiday period....
             if (strtotime($loop_date) >= strtotime($startdate) && strtotime($loop_date) <= strtotime($duration_end)){
               $str_row = $str_row . " class='highlight_days center_cell'";
               $str_total = "<td>$". sprintf('%01.0f', $price) . "</td>"; //total price for selected days
               if ($lowest_price == 0 && $price != "n/a"){
                 $lowest_price = $price;
                 $cheapest_row = $retailer_id;
               }
               else{
                 if ($price < $lowest_price){
                   $lowest_price = $price;
                   $cheapest_row = $retailer_id;
                 }
                }
             }
              else{
                 $str_row = $str_row . " class='center_cell'"; //not in selected holiday period, center cell but don't highlight
              }
            }

            $str_row = $str_row . ">$". sprintf('%01.0f', $price/$days) . "</td>";
            $loop_date = date ("Y-m-d", strtotime("+1 day", strtotime($loop_date)));
            $i = $i+1;
        }//price per day loop
      $str_retailer = "<tr name=cost" . $retailer_id . "><td>". $retailer_name. "</td>";
      $table_data = $table_data . $str_retailer . $str_total . $str_gobutton . $str_row . "</tr>";

      }//check if data returned from price query
    }//retailer/row while loop end
    $table_data = $table_data . "</tbody>";
    echo $table_data;
  }//check if any retailers retruned for the selected resort
  else {
    echo "No retailers found currently servicing " . $resortName . ". Oh dear!";
  }
  $conn->close();



?><!--end php -->


