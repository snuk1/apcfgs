window.onload = () =>{
    let _ = (id) =>{
        return document.getElementById(id);
    }
    
    let btn_conv = _("btn_conv");
    let txt_folder_path = _("txt_folder_path");
    let btn_send = _("btn_send");
    let status = _("status");
    let loading = _("loading");
    let slt_dt_format = _("slt");
    let chk_overwrite = _("chk");
    let chk_get_url;
    
    let convert_and_enable_send = () =>{

        let path = txt_folder_path.value;

        let path_array = path.split("\\");

        let converted_path = "";

        for(i=0; i < path_array.length; i+=1){
            converted_path = converted_path + path_array[i] + "/";
        }

        txt_folder_path.value = converted_path;
        
        btn_send.style.display = "block";
    }

    btn_conv.addEventListener('click', convert_and_enable_send);
    
    //SENDING FOLDER PATH TO update_cfgs.php
    
    $("#frm_folder_path").submit(function(e){
        e.preventDefault();
        
        status.style.display = "block";
        
        if(chk_overwrite.checked){
            chk_get_url = "&chk="+chk_overwrite.checked;
        } else {
            chk_get_url = "";
        }
        
        $.ajax({
            type: "GET",
            url: "populate_cfgs.php?txt_folder_path="+txt_folder_path.value
            +"&slt="+slt_dt_format.value+chk_get_url,
			timeout:0,
            complete:function(response){
                loading.style.display = "none";
                $('#status').html(response.responseText);
            }
        });
        
    });
}