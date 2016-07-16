<?php
/*
Template Name: PricitorPage
*/


  get_header();
  define('DOCROOT', realpath(dirname(__FILE__)));
  //echo DOCROOT;

 // define variables and set to empty values
  $startdate = $package= $packageName= $packageId= $resort= $resortName= $days= $adults= $kids='';

//set up jquery, javascript and enqueue required files

require DOCROOT . '/pricitor/PricitorFunctions.php';




  //check if the form has already been submitted, if so, read the selected options

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startdate = test_input($_POST["start_date"]);
    //$startdate = strtotime($startdate);
    $package = test_input($_POST["selected_package"]);
    $packageName = test_input($_POST["packageName_hidden"]);
    $packageId = test_input($_POST["packageId_hidden"]);
    $resort = test_input($_POST["resort_select"]);
    $resortName = test_input($_POST["resortName_hidden"]);
    $days = test_input($_POST["days_select"]);
    $adults = test_input($_POST["adults_select"]);
    $kids = test_input($_POST["kids_select"]);
  }
  else
  {
    /*if (strtotime(Date("d-m-Y")) >= strtotime(getSeasonStartDate())){
      $startdate = date("d-m-Y");
    }
    else{
      $startdate = getSeasonStartDate();
    }*/
    $startdate = "[--which date?--]";
    $days = "[--days?--]";
    $adults = "temp";
    $kids = "temp";
    $resort = "[--which resort?--]";
    $resortName = "";
    $package = "1";
    $packageId = "sbp";
    $packageName = "ski's boots and poles";
  }


  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
   }
  ?>

 <!-- <div class="first-background"> around the selection area -->

  <div id="bootstyle" class="container">

  <div id="search" class="well semi-transparent-well add-small-gap">

  <h1 id="topBlurb">Going skiing or snowboarding?</h1>
  <h3>
    We can find the best deals on gear for your trip!
    </h3>
  <p>  Just select your resort, number of days and date you plan to arrive below.  We have up to date prices for lots of gear providers in all Australian resorts.  Simply scroll through to select the right gear at the right price for you.</p>

  </div> <!-- end first well -->

  <!-- try container??-->
  <form id="myForm" role="form" method="post" action="#">
  <input type="hidden" name="pricecomp_hidden" id="pricitorHidden" value="Y">
  <input type="hidden" name="resort_hidden" id="resortHidden" value=<?php echo $resort;?>>
  <input type="hidden" name="resortName_hidden" id="resortNameHidden" value="<?php echo htmlspecialchars($resortName);?>">
  <input type="hidden" name="days_hidden" id="daysHidden" value=<?php echo $days;?>>
  <input type="hidden" name="adults_hidden" id="adultsHidden" value=<?php echo $adults;?>>
  <input type="hidden" name="kids_hidden" id="kidsHidden" value=<?php echo $kids;?>>
  <input type="hidden" name="startdate_hidden" id="startdateHidden" value=<?php echo $startdate; ?>>
  <input type="hidden" name="package_hidden" id="packageHidden" value=<?php echo $package; ?>>
  <input type="hidden" name="packageName_hidden" id="packageNameHidden" value="<?php echo htmlspecialchars($packageName);?>">
  <input type="hidden" name="packageId_hidden" id="packageIdHidden" value="<?php echo htmlspecialchars($packageId);?>">
  <div class="well semi-transparent-well">
  <div class="container-fluid add-small-gap">
  <!--add a row to contain the error labels -->
  <div class = "row"> <!-- start row 1 -->
      <div class = "col-md-3 col-md-offset-2"><label id="resortError" class="label label-warning"></label></div>
      <div class = "col-md-2 col-md-offset-1"><label id="daysError" class="label label-warning"></label></div>
      <div class = "col-md-3 col-md-offset-1"><label id="dateError" class="label label-warning"></label></div>
  </div> <!-- end row 1 -->
  <div class="row"> <!-- start row 2 -->
        <div class="col-md-2">
            <h4>I'm heading to</h4>
        </div>
          <div id="resort" class="col-md-3">

        <select name="resort_select" id="resortSelect" class="form-control dropdown-select" data-style="btn-warning" aria-labelledby="dropdownResort">
        <?php
          //if $resort is an integer this means it's been posted so don't add to the options
          if (!filter_var($resort, FILTER_VALIDATE_INT) === false)
          {
          //do nothing, it's a valid int so references one of the options set using jquery on document ready
          }
          else
          {
            //need to display Which Resort?
            $optionD = "<option selected disabled> ";
            $optionD .= $resort;
            $optionD .= "</option>";
            echo $optionD;
          }?>
        <!--get resort options and add to dropdown-->
        <?php require DOCROOT . '/pricitor/PricitorDB.php';
          $sql = "SELECT id, name FROM resort";

try {
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
}catch (\Error $ex) { // Error is the base class for all internal PHP error exceptions.
    var_dump($ex);
    echo "Oops, something went wrong!  Please try again later.";
}



  ?> <!--end php -->
    </select>
          </div><!-- end col 1 row 2 -->
        <div class="col-md-3">
            <div class="row">
              <div class="col-md-4 text-right text-left-sm">
                <h4>
                  For
                </h4>
              </div>
              <div class="col-md-8">
              <select name="days_select" id="daysSelect" class="form-control dropdown-select" data-style="btn-warning" aria-labelledby="dropdownDays">
              <?php
                //if $days is an integer this means the forn has been posted so don't add default line to the options
                if (!filter_var($days, FILTER_VALIDATE_INT) === false)
                {
                //do nothing, it's a valid int so references one of the options which will be set using jquery on document ready

                }
                else
                {
                  //need to display Days?
                  $optionD = "<option selected disabled value=''> ";
                  $optionD .= $days;
                  $optionD .= "</option>";
                  echo $optionD;
                }?>
                <option value="1">1 day</option>
                <option value="2">2 days</option>
                <option value="3">3 days</option>
                <option value="4">4 days</option>
                <option value="5">5 days</option>
                <option value="6">6 days</option>
                <option value="7">7 days</option>
                <option value="8">8 days</option>
                <option value="9">9 days</option>
                <option value="10">10 days</option>
                <option value="11">11 days</option>
                <option value="12">12 days</option>
                <option value="13">13 days</option>
                <option value="14">14 days</option>
              </select>
              </div>
          </div> <!-- end internal row  -->
        </div> <!-- end  col 2 row 2 -->

        <div class="col-md-4" >
          <div class="row">
            <div class="col-md-3 text-center text-left-sm">
              <h4>
                From
              </h4>
            </div>
            <div class= "col-md-9 text-left">
              <div class="input-group">
                <input type="text" id="startDate" name="start_date" class="form-control" value="<?php echo $startdate;?>"/>
                <label for="startDate" class="input-group-addon btn"><span class="fa fa-calendar"></span></label>
              </div>
           </div>
          </div><!-- end internal row -->

        </div> <!-- end col 3 row 2 -->

     </div> <!-- end row 2 -->


<!-- end -->

<!-- Product Options - 3 equal columns-->


     <div id="packageSelect" class="row add-small-gap"> <!-- start row 3 -->
           <div class="col-md-2"><h4>
            I need to hire for</h4></div>
          <div class="col-md-3 col-offset-10 ">
            <h4 >Skiing or </h4>
            <label class="radio" id="sbp1">
            <input type="radio" name="selected_package" id="sbp" value="1">Ski's, boots and poles</label>
             <label class="radio" id="so1">
             <input type="radio" name="selected_package" id="so" value="2" >Ski's only</label>
             <label class="radio" id="sbpjp1">
             <input type="radio" name="selected_package" id="sbpjp" value="3">Ski's, boots, poles, jacket and pants</label>
         </div>
         <div class="col-md-3 col-offset-10">
             <h4>Snow play or </h4>
            <label class="radio" id="tb1">
            <input type="radio" name="selected_package" id="tb" value="4">Toboggan and boots</label>
             <label class="radio" id="jp1">
             <input type="radio" name="selected_package" id="jp" value="5">Jacket and pants</label>
             <label class="radio" id="tbjp1">
             <input type="radio" name="selected_package" id="tbjp" value="6">Toboggan, boots, jacket and pants</label>
         </div>
       <div class="col-md-3 col-offset-10">
             <h4>Snowboarding </h4>
             <label class="radio" id="sbb1">
            <input type="radio" name="selected_package" id="sbb" value="7">Snowboard and boots</label>
            <label class="radio" id="sbo1">
            <input type="radio" name="selected_package" id="sbo" value="8">Snowboard only</label>
            <label class="radio" id="sbbjp1">
            <input type="radio" name="selected_package" id="sbbjp" value="9">Snowboard, boots, jacket and pants</label>
       </div>
    </div> <!-- end row 3 -->
    <div class = "row"> <!-- start row 4 -->
      <div class = "col-md-3 col-md-offset-2"><label id="adultsError" class="label label-warning"></label></div>
  </div> <!-- end row 4 -->
    <div class = "row add-small-gap"> <!-- start row 5 -->
      <div class = "col-md-2">
      <h4>For</h4>
      </div>
      <div class = "col-md-2">
      <select name="adults_select" id="adultsSelect" class="form-control dropdown-select" data-style="btn-warning" aria-labelledby="dropdownAdults">
              <?php
                //if $adults is an integer this means the forn has been posted so don't add default line to the options
                if (!filter_var($adults, FILTER_VALIDATE_INT) === false)
                {
                //do nothing, it's a valid int so references one of the options which will be set using jquery on document ready

                }
                else
                {
                  //need to display adults?
                  $optionD = "<option selected value='1'>1</option>";
                  echo $optionD;
                }?>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
      </div>
      <div class = "col-md-2">
      <h4>Adults and</h4>
      </div>
      <div class = "col-md-2">
      <select name="kids_select" id="kidsSelect" class="form-control dropdown-select" data-style="btn-warning" aria-labelledby="dropdownKids">
              <?php
                //if $kids is an integer this means the forn has been posted so don't add default line to the options
                if (!filter_var($kids, FILTER_VALIDATE_INT) === false)
                {
                //do nothing, it's a valid int so references one of the options which will be set using jquery on document ready

                }
                else
                {
                  //need to display kids?
                  $optionD = "<option selected value='0'>0</option>";
                  echo $optionD;
                }?>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
      </div>
      <div class = "col-md-4 ">
      <h4>Kids (age 14 and under)</h4>
      </div>
    </div> <!-- end row 5 -->
      <div class="row add-medium-gap"> <!-- start row 5 -->
          <div class="col-md-12 text-center">
            <!--<a class="btn btn-primary lg-go-btn" href="#" role="button" type="submit">Go</a>-->
            <input id="btnGo" type="Submit" value="go" class = "btn btn-primary btn-size-lg">
        </div>
      </div> <!-- end row 5 -->
     </div> <!-- end container -->
    </div> <!-- end second well -->
    </form> <!-- form -->

<!-- end -->
  <!-- </div> div background -->

<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include DOCROOT . '/pricitor/PricitorGrid.php';
  }
?>

<?php get_footer(); ?>
