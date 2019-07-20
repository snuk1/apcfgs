<!DOCTYPE html>
<html lang="en">
    <head>
        <title> </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <script src="libs/jquery-3.4.1.min.js"></script>
    </head>
    <body>
        <header>
            <h1 class="g">Auto Populate CFGs</h1>
            <h2 id="info" class="center">
                The games info is gathered using the <span class="g">RAWG API</span>
                (for more info about the API, you can go to 
                 <span class="g">https://rawg.io/apidocs</span>)
            </h2>
            <h3 class="center">To reload the app press <span class="g">F5</span></h3>
        </header>
        <section id="main">
           
            <form name="frm_folder_path" id="frm_folder_path" action="populate_cfgs.php" method="get">
                <div id="input_wrapper" class="center">
                    <div for="" id="lbl_txt">Folder Path:</div>
                    <input type="text" id="txt_folder_path" name="txt_folder_path">
                    <button id="btn_conv" type="button">Convert</button>
                </div>
                <div id="options_wrapper" class="center">
                   <div id="chk_wrapper">
                       <input id="chk" type="checkbox">Overwrite CFGs
                   </div>
                   <div id="slt_wrapper">
                       <span style="color:white">Rel. Dt. Form.:</span>
                       <select id="slt" name="slt_dt_format">
                           <option value="1">DD-MM-YYYY</option>
                           <option value="2">MM-DD-YYYY</option>
                           <option value="3">YYYY-MM-DD</option>
                           <option value="4">DD/MM/YYYY</option>
                           <option value="5">MM/DD/YYYY</option>
                           <option value="6">YYYY/MM/DD</option>
                       </select>
                    </div>
                </div>
                <div id="btn_wrapper" class="center">
                    <button id="btn_send" name="btn_send" type="submit">Populate!</button>
                </div>
            </form>
            
            <div id="status" class="center">
                <div id="loading" class="center"></div>
            </div>
        </section>
        <script type="text/javascript" src="js/script.js"></script>
    </body>
</html>