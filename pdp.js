<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script>
//alert("zaheer");
    var storesec= "mk7ujx2vml";
    var storeauth="cbciescv0jqebshc7ubysazlyc13iqw";
    var productidhere = jQuery(".productView-options input[name=product_id]").val();
    /*var settings = {
  "url": "https://api.bigcommerce.com/stores/"+storesec+"/v3/catalog/products/"+productidhere+"/variants",
  "method": "GET",
  "timeout": 0,
  "headers": {
    "X-Auth-Token": storeauth,
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET,HEAD,OPTIONS,POST,PUT",
    "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept, Authorization"
  },
};

$.ajax(settings).done(function (response) {
  console.log(response);
});
    */
    
    
    jQuery('<div class="qp8911_modal" id="qp8911_bootstrapModal" role="dialog"><div class="qp8911_modal-dialog qp8911_modal-dialog-centered" role="document" ><div class="qp8911_modal-content col-md-8 qp-custom-mage-design"><div class="modal-header"></div><div class="qp8911_modal-body" style="height:70vh"><div class="form-popup" id="myForm" style="border: 1px solid gainsboro;top: 0px;background: white;border-radius: 4px; display: none"><form action="" method="post" class="form-container" id="myformtobesubmit"><input type="hidden" name="order" value="lkld"></form></div><iframe id="qisttpayifram" width="100%" height="100%"  src="" frameborder="0" allowfullscreen style="background: #FFFFFF;" ></iframe></div></div></div></div>').insertAfter("#form-action-addToCart");
     function htmlToElement(html) {
      var template = document.createElement('template');
      html = html.trim(); // Never return a text node of whitespace as the result
      template.innerHTML = html;
      return template.content.firstChild;
  }
  for (const ele of document.querySelectorAll(".btn--add-to-cart,button.product__add-to-cart-button")){
  
     
          ele.style.margin = "10px"
                  let qisstpay_one_click_button_product = `<button type="button" id="1c_product_button"  class="oneclick-button ${ele.className.replace('add-to-cart','').replace('single_add_to_cart_button','')} one-click-button" href="javascript:void(0);" onclick="triggerIFrame()">1-Click Checkout..</button>`;
                  let qisstpay_button_product = htmlToElement(qisstpay_one_click_button_product);
                  ele.parentNode.insertBefore(qisstpay_button_product, ele.nextSibling);
                  
            
  }
    jQuery(".page-content .cart-actions").after('<button type="button" href="javascript:void(0);" id="1c_product_button"  class="cart-page-qp-api-order oneclick-button button button--primary one-click-button" onclick="triggerIFrame()">1-Click Checkout...</button>');
  //custom selector million standards
  var add_to_cart_terms = ['addtocart','addtobag','addtobasket']
  for (const elem of document.querySelectorAll("button,input,a")){
      if(elem.tagName.toLocaleLowerCase() == "input"){
             if(add_to_cart_terms.includes(elem.value.toLowerCase().replace(/\s/g, ''))){
         elem.style.margin = "10px"
                    let qisstpay_one_click_button_product = `<input id="1c_product_button" type="button"  value="1-Click Checkout....." class="oneclick-button ${elem.className.replace('add-to-cart','').replace('single_add_to_cart_button','')} one-click-button" href="javascript:void(0);" onclick="triggerIFrame()" />`;
                    let qisstpay_button_product = htmlToElement(qisstpay_one_click_button_product);
                    elem.parentNode.insertBefore(qisstpay_button_product, elem.nextSibling);
            }
        }
        else if(elem.tagName.toLocaleLowerCase() == "button") {
             if(add_to_cart_terms.includes(elem.textContent.toLowerCase().replace(/\s/g, ''))){
          elem.style.margin = "10px"
                  let qisstpay_one_click_button_product = `<button type="button" id="1c_product_button"  class="oneclick-button ${elem.className.replace('add-to-cart','').replace('single_add_to_cart_button','')} one-click-button" href="javascript:void(0);" onclick="triggerIFrame()">1-Click Checkout.</button>`;
                  let qisstpay_button_product = htmlToElement(qisstpay_one_click_button_product);
                  elem.parentNode.insertBefore(qisstpay_button_product, elem.nextSibling);
                  
            }
        }
        else if (elem.tagName.toLocaleLowerCase() == "a") {
             if(add_to_cart_terms.includes(elem.textContent.toLowerCase().replace(/\s/g, ''))){
          elem.style.margin = "10px"
                  let qisstpay_one_click_button_product = `<a id="1c_product_button"  class="oneclick-button ${elem.className.replace('add-to-cart','').replace('single_add_to_cart_button','')} one-click-button" href="javascript:void(0);" onclick="triggerIFrame()">1-Click Checkout....</a>`;
                  let qisstpay_button_product = htmlToElement(qisstpay_one_click_button_product);
                  elem.parentNode.insertBefore(qisstpay_button_product, elem.nextSibling);
            }
        }
    }
    
    function triggerIFrame() {
      //alert("I am an alert box!");
      var productId = jQuery(".productView-info-value").text();
      var productImage = jQuery(".productView-images .productView-img-container a").attr('href');
      var productQuantity = jQuery(".add-to-cart-wrapper .form-input--incrementTotal").val();
      var productPrice = jQuery(".productView-price .price--withoutTax").text();
      productPrice = productPrice.replace(/[\$£€฿Rs]/g, '');
      var productTitle = jQuery(".productView-title").text();
      var productShipping = '[{"title":"Default","cost":"200"}]';
      var baseurl = window.location.origin;
      var productcolor = jQuery(".productView-options .form-field .form-label span").text();
       if(jQuery(".productView-options .form-select option:selected").text() == ''){
         var productsize = jQuery(".productView-options .form-radio:checked+.form-option").text();
       }else{
            var productsize = jQuery(".productView-options .form-select option:selected").text();
       }
       console.log(productsize);
      console.log(productcolor);
      // console.log(productQuantity);
       console.log(productPrice);
       console.log(productTitle);


      var i = 0;
      var visual = jQuery(".swatch-attribute.visual").length;
      var j = 0;
      var max = jQuery(".swatch-attribute").length;
      var keys = [];
      var indexing = [];
      while (i < max) {
          keys.push(jQuery(jQuery(".swatch-opt .swatch-attribute:nth-child("+i+")")).find(":selected").text());
          indexing.push(jQuery(".swatch-opt .swatch-attribute:nth-child("+i+") .swatch-attribute-label").text());
          // if(j<visual && jQuery(".swatch-attribute-options").find(".swatch-option.selected").attr("aria-label")){
          //   keys.push(jQuery(".swatch-attribute-options").find(".swatch-option.selected").attr("aria-label"));
          //     j++;
          // }
          i++;
      }
        console.log(keys);
        console.log("###############################################");
      while (j < visual) {
        if(j<visual && jQuery(".swatch-attribute-options").find(".swatch-option.selected").attr("aria-label")){
          keys.push(jQuery(".swatch-attribute-options").find(".swatch-option.selected").attr("aria-label"));
          indexing.push(jQuery(".swatch-opt .swatch-attribute:nth-child("+i+") .swatch-attribute-label").text());
            j++;
        }
      }
      var indexed = indexing.filter(function(v){return v!==''});
      var valued = keys.filter(function(v){return v!==''});

      var k = 0;
      var resultant = {};
      while (k < max) {
          resultant[indexed[k]] = valued[k];
          k++;
      }
      console.log(resultant);
      var attris = '';
      for (var key in resultant) {
          var value = resultant[key];
          //console.log(key, value);
          attris = attris+'"'+key+'":"'+value+'",';
      }
      // console.log(indexing);
      //console.log(attris);

      var streamhit = 'products=[{"id":"'+productId+'","src":"'+productImage+'","quantity":"'+productQuantity+'","attributes":[{"attribute_pa_test-att":"blue","variation_id":"3935"}],"price":'+productPrice+',"title":"'+productTitle+'"}]&price='+productPrice+'&currency=PKR&url=https://sandbox.wordpress.qisstpay.com/wp-json/qisstpay/teez/&shipping_total=0&tax=0&shipping_methods='+productShipping;
      streamhit = streamhit.replace(',}', '}');

      var streatfinal = btoa(unescape(encodeURIComponent(streamhit)));
      var baseuri = btoa(unescape(encodeURIComponent(baseurl)));
      var bata = 'https://sandbox.tezcheckout.qisstpay.com/?identity-token='+baseuri+'\&'+'queryUrl=';

      // var sourceString = bata+'cHJvZHVjdHM9W3siaWQiOiIxNTk0Iiwic3JjIjoiaHR0cHM6Ly9zYW5kYm94LndvcmRwcmVzcy5xaXNzdHBheS5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMjEvMTEvNjY2NjY2NjY2NjY2LmpwZWciLCJxdWFudGl0eSI6IjEiLCJhdHRyaWJ1dGVzIjpbeyJhdHRyaWJ1dGVfcGFfdGVzdC1hdHQiOiJibHVlIiwidmFyaWF0aW9uX2lkIjoiMzkzNSJ9XSwicHJpY2UiOjE2MDAsInRpdGxlIjoiU2hpcnQifV0mcHJpY2U9MTYwMCZjdXJyZW5jeT1QS1ImdXJsPWh0dHBzOi8vc2FuZGJveC53b3JkcHJlc3MucWlzc3RwYXkuY29tL3dwLWpzb24vcWlzc3RwYXkvdGVlei8mc2hpcHBpbmdfdG90YWw9MjAwJnRheD0zNiZzaGlwcGluZ19tZXRob2RzPVt7InRpdGxlIjoiRmxhdCByYXRlIiwiY29zdCI6IjIwMCJ9LHsidGl0bGUiOiJMb2NhbCBwaWNrdXAiLCJjb3N0IjoiMzUwIn0seyJ0aXRsZSI6IkZyZWUgc2hpcHBpbmciLCJjb3N0IjowfV0=';

      //console.log(datastreaming);
        
      //var datastreaming = bata;
var datastreaming = bata+streatfinal;
      let unescapedurl=unescape(datastreaming);
      // console.log(streamhit);
      // console.log(streatfinal);
      // console.log(unescapedurl);
      //var newStream = datastreaming.replace(/&amp;/g, '&');

      jQuery("#qisttpayifram").attr('src', unescapedurl);
      // jQuery("#qisttpayifram").attr('src', function(index, text) {
      //   return text.replace('&amp;', '&');
      // });
      window.addEventListener('message', function(e) {
                      // Get the sent data
                      const data = e.data;

                      try {
                          if(data.qp_flag_teez == true){
                              window.location.href= data.link;
                              ///form Submit
                          } else if(data.qp_flag_teez == false) {
                              jQuery('.qp8911_modal').hide();
                              jQuery('body').css('position', 'initial');
                              jQuery('body').css('width', 'initial');
                              jQuery('.qisttpayifram').attr('src', null);
                          }
                      } catch(e){
                          return;
                      }
                  });
      jQuery('#qp8911_bootstrapModal').show();
      jQuery('#closed').click(function(){
          //location.reload();
          jQuery('#qp8911_bootstrapModal').hide();
      })
    }
    
    
</script>
<script>$('<style>').text('.one-click-button{     margin:10px;          background-color: #e82e81 !important;         color: white !important;         cursor: pointer !important;         text-decoration:none !important;         text-transform:capitalize !important;         border:none;       }       .qp8911_modal {       display: none; /* Hidden by default */       position: fixed; /* Stay in place */       z-index: 1000; /* Sit on top */       padding-top: 80px; /* Location of the box */       left: 0;       top: 0;       width: 100%; /* Full width */       height: 100%; /* Full height */       overflow: auto; /* Enable scroll if needed */       background-color: #00000099; /* Fallback color */       background-color: #00000099; /* Black w/ opacity */     }     /* qp8911_modal Content */     .qp8911_modal-content {         background-color: #fefefe;    height: 70vh;         margin: auto;         width: 30%;         padding: 0px !important;         border-radius: 16px;     }            .qisstpay_popup__paragraph_Styles{         font-size: 13px;         text-align: center;         color: #707986;         padding:0px 6px;     }     .qisstpay___image__overLay_Popup {       position: fixed;       top: 0;       bottom: 0;       left: 0;       right: 0;       background: rgb(0 0 0 / 36%);       transition: opacity 500ms;       display:none;       align-items: center;       z-index:9999;     }          .qisstpay__popup_whatisQp {       margin: 70px auto;       padding-bottom: 20px;       background: #fff;       border-radius: 5px;       width: 50%;       position: relative;       transition: all 1s ease-in-out;       z-index:999;     }          .qisstpay__popup_whatisQp .qisstpay_popupMOdal_close_btn {         position: absolute;         top: -10px;         right: 11px;         transition: all 200ms;         font-size: 40px;         font-weight: 400;         text-decoration: none;         color: black;         z-index: 999;         height: 55px;     }     .Logo_redirect_qisstPay{         display:block;         text-align:center;     }          .qisstpay___image__ForDesktop:focus-visible{      outline:none;     }     .QisstPay_modal_openBTn_click{         background: transparent;         color: black;         height: 19px;         width: 19px;         font-size: 13px;         font-style: italic;         font-weight: 700;         margin-left: 15px;         cursor: pointer;         margin-bottom: 10px;         z-index: 99;         display: inline-flex;         align-items: center;         justify-content: center;         border: 1px solid;         border-radius: 50%;     }     .qisstpay___image__ForMobile{         display:none     }     .Logo_redirect_qisstPay img{         margin-top: 12px;         height: 65px !important;         margin-bottom: 7px;     }     @media(max-width:767px){     .Logo_redirect_qisstPay_mob{         display:block;         text-align:center;          background: #fcebf3;     }     .Logo_redirect_qisstPay_mob a{         width: 70%;         margin: auto;         padding-top: 15px;         display:inline-block;     }     .qisstpay___image__ForMobile{         display:block;     }     .qisstpay__popup_whatisQp{         width: 86%;         max-height: 80vh;         overflow-y: scroll;       }       .qisstpay___image__ForDesktop{         display:none;     }     .Logo_redirect_qisstPay_mob:focus{         background:#fcebf3 !important;     }     }     @media(min-width:768px) and (max-width:991px){       .qisstpay__popup_whatisQp{           width:75%;       }              }     @media(min-width:992px) and (max-width:1200px){         .qisstpay__popup_whatisQp{           width:70%;       }       }          .teez-button {         width: 100% !important;         height: 50px !important;         border-radius: 8px !important;         font-weight: 700 !important;         font-size: 18px !important;         background-color: #e82e81 !important;         color: white !important;         cursor: pointer !important;         display: flex !important;         -webkit-box-align: center !important;         align-items: center !important;         -webkit-box-pack: center !important;         justify-content: center !important;         border: 1px solid #e82e81 !important;         outline-color: transparent !important;         margin-bottom: 0.5rem !important;         text-decoration: none !important;     }          .teez-button:focus {         text-decoration: none !important;         color: #fff !important;     }          .teez-button:hover {         text-decoration: none !important;         color: #fff !important;     }          .qp8911_modal-body.teez {         position: relative !important;     }          .qp-lds-roller {         display: inline-block;         position: relative;         left: 50%;         transform: translate(-50%,-50%) !important;         top: 50% !important;         position: absolute !important;       }       .qp-lds-roller div {         animation: qp-lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;         transform-origin: 40px 40px;       }       .qp-lds-roller div:after {         content: " ";         display: block;         position: absolute;         width: 7px;         height: 7px;         border-radius: 50%;         background: linear-gradient(82deg, #e82e81, #fc6473);         margin: -4px 0 0 -4px;       }       .qp-lds-roller div:nth-child(1) {         animation-delay: -0.036s;       }       .qp-lds-roller div:nth-child(1):after {         top: 63px;         left: 63px;       }       .qp-lds-roller div:nth-child(2) {         animation-delay: -0.072s;       }       .qp-lds-roller div:nth-child(2):after {         top: 68px;         left: 56px;       }       .qp-lds-roller div:nth-child(3) {         animation-delay: -0.108s;       }       .qp-lds-roller div:nth-child(3):after {         top: 71px;         left: 48px;       }       .qp-lds-roller div:nth-child(4) {         animation-delay: -0.144s;       }       .qp-lds-roller div:nth-child(4):after {         top: 72px;         left: 40px;       }       .qp-lds-roller div:nth-child(5) {         animation-delay: -0.18s;       }       .qp-lds-roller div:nth-child(5):after {         top: 71px;         left: 32px;       }       .qp-lds-roller div:nth-child(6) {         animation-delay: -0.216s;       }       .qp-lds-roller div:nth-child(6):after {         top: 68px;         left: 24px;       }       .qp-lds-roller div:nth-child(7) {         animation-delay: -0.252s;       }       .qp-lds-roller div:nth-child(7):after {         top: 63px;         left: 17px;       }       .qp-lds-roller div:nth-child(8) {         animation-delay: -0.288s;       }       .qp-lds-roller div:nth-child(8):after {         top: 56px;         left: 12px;       }       @keyframes qp-lds-roller {         0% {           transform: rotate(0deg);         }         100% {           transform: rotate(360deg);         }       }     @media only screen and (max-width: 600px) {       .qp8911_modal-content {width: 90%;}     }          /* Small devices (portrait tablets and large phones, 600px and up) */     @media only screen and (min-width: 600px) {       .qp8911_modal-content {width: 70%;}     }          /* Medium devices (landscape tablets, 768px and up) */     @media only screen and (min-width: 768px) {         .qp8911_modal-content {width: 50%;}     }           /* Large devices (laptops/desktops, 992px and up) */     @media only screen and (min-width: 992px) {         .qp8911_modal-content {width: 38%;}     }           /* Extra large devices (large laptops and desktops, 1200px and up) */     @media only screen and (min-width: 1200px) {         .qp8911_modal-content {width: 30%;}     }          .one-click-button.spinning {       padding-right: 40px;       background-color: grey !important;     }     ').appendTo(document.head)</script>
