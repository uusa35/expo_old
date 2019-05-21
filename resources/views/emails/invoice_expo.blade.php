<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <title>My Expo</title>
        
        <style>
            .container {
                width: 700px;
                margin: auto;
            }
            .text-center {
                text-align: center !important
            }
            .logo {
                float: left;
                width: 70px;
                height: 70px;
                overflow: hidden
            }
            .secHead {
                float: right;
                margin-top: 50px;
            }
            .clearfix {
                clear: both
            }
            .titleBody h4 {
                margin-bottom: 0;
            }
            .titleBody p {
                margin: 0;
            }
            .secBody .titleBody, .secBody .tableBody{
                padding: 10px 40px
            }
            #customers {
                border-collapse: collapse;
                width: 100%;
            }
            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 8px;
                font-weight: bold
            }
            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                color: #000;
            }
            .width50px {
                width: 60px
            }
            .text-right {
                text-align: right !important
            }
            .text-left {
                text-align: left !important;
                float: left
            }
            .rightF {
                float: right
            }
            .sectit {
                 padding: 0px 40px;
                text-align: center
            }
            .sectit p {
                text-align: justify
            }
        </style>
    </head>
    
    <body>
        
        
        <div class="header">
            <div class="container">
                <div class="logo">
                    <img src="http://myexpo.shop/logo.png" width="70" height="70" />
                </div>
                <div class="secHead">
                    <p>Commercial receipt</p>
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
        
        <div class="secBody">
           <div class="container">
            <div class="titleBody">
                <h4>Hi {{$expo_name}}</h4>
                <p>You have new Order number: <span>{{$order_id}}</span></p>
            </div>
            <div class="tableBody">
                <table id="customers">
                  <tr>
                     <th>Customer details</th>
                     <th>Order details</th>
                  </tr>
                  <tr>
                    <td valign="top">
                        Name: <span>{{$name}}</span>
                        <br>
                        <br>
                        Phone: <span>{{$mobile}}</span> 
                        <br>
                        <br>
                        Address: <span>{{$address}}</span> 
                        <br>
                    </td>
                    <td valign="top">
                        Order time: <span>{{date("Y-m-d H:i")}}</span> 
                    <br>
                    <br>
                        Payment method: <span>Cash</span>
                    </td>
                  </tr>
              </table>

                <table id="customers">
                  <tr>
                     <th class="width50px">Qty.</th>
                     <th>Item</th>
                     <th>Color</th>
                     <th>Size</th>
                     <th>Material</th>
                     <th class="width50px">Unit Price (KD)</th>
                     <th class="width50px">Subtotal (KD)</th>
                     
                  </tr>
                   
                   @foreach($order as $item)
                    
                  <tr>
                        <td class="width50px"><span class="text-left">{{$item->quantity}}</span></td>
                        <td><span>{{$item->product_name}}</span></td>
                        <td><span><div style="width:30px; height:30px; background-color:#{{@$item->color->color}}"></div></span></td>
                        <td><span>{{@$item->product_size}}</span></td>
                        <td><span>{{@$item->product_material}}</span></td>
                        <td class="width50px"><span class="text-right">{{$item->price}}</span></td>
                        <td class="width50px"><span class="text-right">{{$item->total}}</span></td>
                  </tr>
                  @endforeach
                  
                  <tr>
                    <td colspan="6">&nbsp;</td>
                    <td class="text-right" colspan="2">
                        Total: <span>{{$total_cost}} K.D</span>
                    </td>
                  
                  </tr>
              </table>
           
            </div>
          </div>
        </div>
        
        <div class="footer">
           <div class="container">
              <div class="sectit">
                  <h3>Thank you for ordering by My Expo</h3>
                  <p>These products have been prepared by the store that was ordered from My Expo. My Expo is not involved in any way in the process of preparation, production, or pricing of this product. The store that was ordered from is responsible for the quality, pricing and the validity of the products and in turn My Expo disclaims itself from any responsibility for any damage that might arise along this transaction. This report is attached to the order as a proof of the details of this transaction and to reflect the delivery charge. The store has the sole responsibility of pricing, quality and any difference that exist between price displayed on My Expo and the menus of the store shall be the responsibility of the store.
               <br>
               <br>
               <br>
               <br>
               <span>This email is delivered by My Expo Application</span>
              </div>
            </div>
        </div>
        
    </body>
    
</html>