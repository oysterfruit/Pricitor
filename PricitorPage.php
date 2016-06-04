<?php
/*
Template Name: PricitorPage
*/

  get_header();


//set up jquery, javascript and enqueue required files

require '/pricitor/PricitorFunctions.php';
?>


  <?php

  // define variables and set to empty values
  $startdate = $package= $packageName= $packageId= $resort= $resortName= $days='';
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

  <div class="first-background"> <!-- around the selection area-->

  <div class="container add-gap">

  <div class="well semi-transparent-well">

  <h1 id="topBlurb">Going skiing or snowboarding?</h1>
  <h3>
    We can find the best deals on gear for your trip!
    </h3>
  <p>  Just select your resort, number of days and date you plan to arrive below.  We have up to date prices for lots of gear providers in all Australian resorts.  Simply scroll through to select the right gear at the right price for you.</p>

  </div> <!-- end first well -->

  <!-- try container??-->
  <form id="myForm" role="form" method="post" action="http://localhost/wp1/prices/#">
  <input type="hidden" name="pricecomp_hidden" id="pricitorHidden" value="Y">
  <input type="hidden" name="resort_hidden" id="resortHidden" value=<?php echo $resort;?>>
  <input type="hidden" name="resortName_hidden" id="resortNameHidden" value="<?php echo htmlspecialchars($resortName);?>">
  <input type="hidden" name="days_hidden" id="daysHidden" value=<?php echo $days;?>>
  <input type="hidden" name="startdate_hidden" id="startdateHidden" value=<?php echo $startdate; ?>>
  <input type="hidden" name="package_hidden" id="packageHidden" value=<?php echo $package; ?>>
  <input type="hidden" name="packageName_hidden" id="packageNameHidden" value="<?php echo htmlspecialchars($packageName);?>">
  <input type="hidden" name="packageId_hidden" id="packageIdHidden" value="<?php echo htmlspecialchars($packageId);?>">
  <div class="well semi-transparent-well">
  <div class="container-fluid add-small-gap">
  <!--add a row to contain the error labels -->
  <div class = "row">
      <div class = "col-md-3 col-md-offset-2"><label id="resortError"></label></div>
      <div class = "col-md-2 col-md-offset-1"><label id="daysError"></label></div>
      <div class = "col-md-3 col-md-offset-1"><label id="dateError"></label></div>
  </div>
  <div class="row">
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
        <?php require '/pricitor/PricitorDB.php';
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
    </select>
          </div>
        <div class="col-md-3">
            <div class="row">
              <div class="col-md-4 text-right">
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
          </div>
        </div>

        <div class="col-md-4" >
          <div class="row">
            <div class="col-md-3 text-center">
              <h4>
                From
              </h4>
            </div>
            <div class= "col-md-9 text-left">
              <div class="input-group">
                <input type="text" id="startDate" name="start_date" value="<?php echo $startdate;?>"/>
                <label for="startDate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>
              </div>
           </div>
          </div>

        </div>

     </div>
  </div>

<!-- end -->

<!-- Product Options - 3 equal columns-->

    <div class="container-fluid add-small-gap add-small-end-gap">
     <div class="row">
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
    </div>
    </div>
    <div class="container container-fluid add-small-gap">
      <div class="row add-sm-gap">
          <div class="col-md-12 text-center">
            <!--<a class="btn btn-primary lg-go-btn" href="#" role="button" type="submit">Go</a>-->
            <input id="btnGo" type="Submit" value="go" class = "btn btn-primary btn-size-lg">
        </div>
      </div>
    </div>
    </div> <!-- end second well -->
    </form> <!-- form -->


    </div> <!--container -->

<!-- end -->
  </div> <!--div background -->

<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '/pricitor/PricitorGrid.php';
  }
?>

<?php get_footer(); ?>
