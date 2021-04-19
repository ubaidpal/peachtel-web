<div id="alert" style="display: none">
    <div id="alertContent">
        <h2>Alert</h2>
        <p>Are you sure your want to delete configuration?</p>
        <div id="alertActions">
            <input type="hidden" id="delete_mac_id"/>
            <button class="btn btn-small btn-primary" id="confirmly_delete">Confirm</button>
            <button class="btn btn-small btn-quaternary" id="hide_alert">Cancel</button>
        </div>
    </div>
    <a class="close" id="close_alert" href="javascript:void(0);">×</a>
</div>

<div id="alert2" style="background-color: rgb(255, 255, 255); border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.75); left: 50%; position: fixed; z-index: 100; margin-left: -203px; top: 50px; width: 276px;height:136px;display: none;">
    <div id="alertContent" style="margin-left:73px">
        <h2 style="margin-left:30px">Alert</h2>
        <p>Already Provisioned </p>
        <div id="alertActions">
            <input type="hidden" id="serial_num"/>
            <button class="btn btn-small btn-primary" id="hide_alert2" style="margin-right:23px;padding-left:19px;padding-right:19px;">OK</button>
           
        </div>
    </div>
</div>