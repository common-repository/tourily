<?php
// bootstrap our wordpress instance
$bootstrapSearchDir = dirname($_SERVER["SCRIPT_FILENAME"]);
$docRoot = dirname(isset($_SERVER["APPL_PHYSICAL_PATH"]) ? $_SERVER["APPL_PHYSICAL_PATH"] : $_SERVER["DOCUMENT_ROOT"]);

while (!file_exists($bootstrapSearchDir . "/wp-load.php")) {
  $bootstrapSearchDir = dirname($bootstrapSearchDir);
  if (strpos($bootstrapSearchDir, $docRoot) === false){
    $bootstrapSearchDir = "../../../../.."; // critical failure in our directory finding, so fall back to relative
    break;
  }
}
require_once($bootstrapSearchDir . "/wp-load.php");
require_once($bootstrapSearchDir . "/wp-admin/admin.php");

$localJsUri = get_option("siteurl") . "/" . WPINC . "/js/";
?>

<html>
  <head>
    <link rel="stylesheet" href="editor.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="<?php echo $localJsUri ?>tinymce/tiny_mce_popup.js?ver=<?php echo urlencode($tinymce_version) ?>"></script>
    <script type="text/javascript" src="insert.js"></script>
  </head>
  <body>

    <h1>Insert Tourily Listings</h1>

    <label for="tourily_price_min">Minimum Price</label>
    <input type="text" id="tourily_price_min" value="0">

    <label for="tourily_price_max">Maximum Price</label>
    <input type="text" id="tourily_price_max" value="100,000,000">

    <label for="tourily_status">Status</label>
    <select id="tourily_status">
      <option value="all">All</option>
      <?php $statuses = get_option(TOURILY_OPTION_STATUS, array()) ?>
      <?php foreach($statuses as $name => $listings): ?>
        <option value="<?php echo $name ?>"><?php echo $name ?></option>
      <?php endforeach ?>
    </select>

    <label for="tourily_zip_code">Zip Code</label>
    <select id="tourily_zip_code">
      <option value="all">All</option>
      <?php $zip_codes = get_option(TOURILY_OPTION_ZIPCODE, array()) ?>
      <?php foreach($zip_codes as $name => $listings): ?>
        <option value="<?php echo $name ?>"><?php echo $name ?></option>
      <?php endforeach ?>
    </select>

    <label for="tourily_city">City</label>
    <select id="tourily_city">
      <option value="all">All</option>
      <?php $cities = get_option(TOURILY_OPTION_CITY, array()) ?>
      <?php foreach($cities as $name => $listings): ?>
        <option value="<?php echo $name ?>"><?php echo $name ?></option>
      <?php endforeach ?>
    </select>

    <label for="tourily_subdivision">Subdivision</label>
    <select id="tourily_subdivision">
      <option value="all">All</option>
      <?php $subdivisions = get_option(TOURILY_OPTION_SUBDIVISION, array()) ?>
      <?php foreach($subdivisions as $name => $listings): ?>
        <option value="<?php echo $name ?>"><?php echo $name ?></option>
      <?php endforeach ?>
    </select>

    <label for="tourily_community">Community</label>
    <select id="tourily_community">
      <option value="all">All</option>
      <?php $communities = get_option(TOURILY_OPTION_COMMUNITY, array()) ?>
      <?php foreach($communities as $name => $listings): ?>
        <option value="<?php echo $name ?>"><?php echo $name ?></option>
      <?php endforeach ?>
    </select>

    <input type="submit" id="InsertTourilyCode" value="Insert">

  </body>
</html>
