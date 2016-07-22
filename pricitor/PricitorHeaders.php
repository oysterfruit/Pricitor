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
  $active_page_start= date("d M y", strtotime($days_diff_str, strtotime($startdate)));

  if (strtotime($active_page_start) < strtotime($season_start_date)){
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
  $table_headers = "<thead><tr><th class='col-fixed-160'>Retailer</th><th></th><th>Total</th><th></th>";
  $loop_date = $season_start_date;
  $i=1;

  while (strtotime($loop_date) <= strtotime($season_end_date)) {
     $day_name =  Date("D", strtotime($loop_date));
     $mon_name =  Date("M", strtotime($loop_date));
     $day_digit = Date("d", strtotime($loop_date));
     $col_name = "tcol" . strval($i);

     $table_headers = $table_headers . "<th name=" . $col_name;
    if (strtotime($loop_date) < strtotime($active_page_start) || (strtotime($loop_date) > strtotime($active_page_end))){

       $table_headers = $table_headers . " class='myHide center_cell myHide-sm'";
     }
     else
     {
       if (strtotime($loop_date) >= strtotime($startdate) && strtotime($loop_date) <= strtotime($duration_end)){
         $table_headers = $table_headers . " class='info center_cell myHide-sm'";

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
         $table_headers = $table_headers . " class='center_cell myHide-sm'";
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

  $sql = "SELECT DISTINCT retailer.name, retailer.location, retailer.Internal_link, retailer.Store_discount_active, retailer.Store_discount_perc, retailer.Store_discount_desc, retailer.weblink, resort_retailer.retailer_id FROM retailer, resort_retailer WHERE resort_retailer.retailer_id = retailer.id and resort_retailer.resort_id = " . $resort;
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
      $str_internalLink = $row["Internal_link"];
      $str_store_discount_active = $row["Store_discount_active"];
      $str_discount_perc = $row["Store_discount_perc"];
      $str_discount_desc = $row["Store_discount_desc"];
      $str_gobutton = "<td class='center_cell'><a href='" . $str_weblink . "' target='_blank' role='button' class='btn btn-info'><i class='fa fa-shopping-bag' aria-hidden='true'></i></a></td>";
      $retailer_name = $row["name"];
      $retailer_id = $row["retailer_id"];

      //first check if there is a discount and get it into the correct format
      if ($str_store_discount_active == 1){
          $str_discount_perc = 100 - $str_discount_perc;
          $str_discount_perc = $str_discount_perc/100;
      }

      $sql2 = "SELECT Start_date, End_Date, Price, Price_child FROM price WHERE retailer_id = " . $retailer_id . " AND package_id = " . $package . " AND Days = " . $days;

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
          $total_price = "n/a";
          $price = "n/a";
          $price_child = "n/a";
          $j = 0; //array counter
          for ($j = 0; $j < count($price_array); $j++) {
            $price_startdate = $price_array[$j]['Start_date'];
            $price_enddate = $price_array[$j]['End_Date'];
            if (strtotime($loop_date) >= strtotime($price_startdate) && strtotime($loop_date) <= strtotime($price_enddate)) {
              $price = $price_array[$j]['Price'];
              $price_child = $price_array[$j]['Price_child'];
              //first check if there is a discount and apply it
              if ($str_store_discount_active == 1){
                $price = $price * $str_discount_perc;
                $price_child = $price_child * $str_discount_perc;
              }
              $total_adults = $price * $adults;
              $total_kids = $price_child *$kids;
              $total_price = $total_adults + $total_kids;
              break;
            }
          }//end for loop

          //work out whether to show or hide this column
          if (strtotime($loop_date) < strtotime($active_page_start) || (strtotime($loop_date) > strtotime($active_page_end)))
            {
              $str_row = $str_row . " class='myHide center_cell myHide-sm'"; //cell off screen so hide it
            }
            else
           { //if the current cell is during the selected holiday period....
             if (strtotime($loop_date) >= strtotime($startdate) && strtotime($loop_date) <= strtotime($duration_end)){
               $str_row = $str_row . " class='info center_cell myHide-sm'";
               $str_total = "<td name=colTotal data-toggle='popover' data-trigger='hover' title= 'Adult: $" . sprintf('%01.0f', $price) . ", Child: $" . sprintf('%01.0f', $price_child). "' class='center_cell'>$". sprintf('%01.0f', $total_price) . "</td>"; //total price for selected days
               if ($lowest_price == 0 && $total_price != "n/a"){
                 $lowest_price = $total_price;
                 $cheapest_row = $retailer_id;
               }
               else{
                 if ($total_price < $lowest_price){

                   $lowest_price = $total_price;
                   $cheapest_row = $retailer_id;
                 }
                }
             }
              else{
                 $str_row = $str_row . " class='center_cell myHide-sm'"; //not in selected holiday period, center cell but don't highlight
              }
            }
            //the db price is for the total days, divide by $days to display the price per day in the grid

            $str_row = $str_row .  ">$". sprintf('%01.0f', $total_price/$days) . "</td>";

            $loop_date = date ("Y-m-d", strtotime("+1 day", strtotime($loop_date)));
            $i = $i+1;
        }//price per day loop
      //set up start of row with retailer, internal link, any discount
      $str_retailer = "<tr name=cost" . $retailer_id . "><td><a href='". $str_internalLink . "' target='_blank'>" . $retailer_name. "</a></td>";
        if ($str_store_discount_active == 1){
            //add flame icon and popover text
            $str_retailer .= "<td><span class='fa-stack fa-lg text-warning' aria-hidden='true' data-toggle='popover' data-trigger='hover' title='" . $str_discount_desc . "'>
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-bolt fa-stack-1x fa-inverse'></i></td>";
        }else
          //add blank cell
        {
          $str_retailer .= "<td></td>";
        }

        $table_data = $table_data . $str_retailer . $str_total . $str_gobutton . $str_row . "</tr>";

      }//check if data returned from price query
    }//retailer/row while loop end
    $table_data = $table_data . "</tbody>";
    echo $table_data;
  }//check if any retailers returned for the selected resort
  else {
    echo "No retailers found currently servicing " . $resortName . ". Oh dear!";
  }
  $conn->close();



?><!--end php -->


