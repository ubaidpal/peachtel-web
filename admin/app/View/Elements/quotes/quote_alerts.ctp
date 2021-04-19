<div id="review_quote_container" style="display:none;"></div>
<div id="overlay" style="display: none"></div>
<div id="alert3" style="background-color: rgb(255, 255, 255); border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.75); left: 50%; position: fixed; z-index: 100; margin-left: -197px; top: 50px; width: 395px; height: 210px; display: none;">
    <div id="alertContent" style="margin-left:18px">
        <h1 style="color: green">Quote has been saved.</h1>
        <hr />
        <li>If you are currently logged in prestashop, </li>
        <li>Please logout your account and relogin.</li>
        <li>This process will update your prestashop cart.</li>
        <hr />
        
        <div id="alertActions" style="margin-top:5px">
            <input type="hidden" id="serial_num"/>
            <button class="btn btn-small btn-primary" id="hide_alert2" style="padding:5px 19px;">OK</button>
        </div>
    </div>
</div>

<div id="alert4" style="background-color: rgb(255, 255, 255); border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.75); left: 50%; position: fixed; z-index: 100; margin-left: -203px; top: 50px; width: 330px; display:none;">
    <div id="alertContent" style="margin-left:18px">
        <h1 style="color: green; margin-bottom: .5em;">Checkout Review</h1>
        <hr style="margin: 10px 0;" />
        <label style="font-size: 16px;">Please review your checkout info. </label>
        <hr style="margin: 10px 0;" />
        <div id="review_container">
        </div>
        <hr style="margin: 10px 0;" />
        <div id="alertActions" style="margin-top:5px; text-align: right;">
            <input type="hidden" id="serial_num"/>
            <button class="btn btn-small btn-primary" id="proceedCheckout" style="padding:5px 19px;">Proceed</button>
            <button class="btn btn-small btn-primary" id="cancelCheckout" style="padding:5px 19px;">Cancel</button>
        </div>
    </div>
</div>

<div id="alert6" style="background-color: rgb(255, 255, 255); border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.75); left: 50%; position: fixed; z-index: 100; margin-left: -197px; top: 50px; width: 330px; height: 170px; display: none;">
    <div id="alertContent" style="margin-left:18px; width: 270px">
        <h1 style="color: green">Are you sure?</h1>
        <hr />
        <li>This will erase you current quote.</li>
        <li>Please save you quote before proceeding.</li>
        <hr />
        
        <div id="alertActions" style="margin-top:5px">
            <input type="hidden" id="serial_num"/>
            <button class="btn btn-small btn-primary" id="proceed" style="padding:5px 19px;">Yes</button>
            <button class="btn btn-small btn-primary" id="newcancel" style="padding:5px 19px;">No</button>
        </div>
    </div>
</div>