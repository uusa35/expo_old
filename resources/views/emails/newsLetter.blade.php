<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style type="text/css">
        * {
            -ms-text-size-adjust:100%;
            -webkit-text-size-adjust:none;
/*
            -webkit-text-resize:100%;
            text-resize:100%;
*/
        }
        a{
            outline:none;
            color:#40aceb;
            text-decoration:underline;
        }
        a:hover{text-decoration:none !important;}
        .nav a:hover{text-decoration:underline !important;}
        .title a:hover{text-decoration:underline !important;}
        .title-2 a:hover{text-decoration:underline !important;}
        .btn:hover{opacity:0.8;}
        .btn a:hover{text-decoration:none !important;}
        .btn{
            -webkit-transition:all 0.3s ease;
            -moz-transition:all 0.3s ease;
            /*-ms-transition:all 0.3s ease;*/
            transition:all 0.3s ease;
        }
        table td {border-collapse: collapse !important;}
        /*.ExternalClass, .ExternalClass a, .ExternalClass span, .ExternalClass b, .ExternalClass br, .ExternalClass p, .ExternalClass div{line-height:inherit;}*/
        @media only screen and (max-width:500px) {
            table[class="flexible"]{width:100% !important;}
            table[class="center"]{
                float:none !important;
                margin:0 auto !important;
            }
            *[class="hide"]{
                display:none !important;
                width:0 !important;
                height:0 !important;
                padding:0 !important;
                font-size:0 !important;
                line-height:0 !important;
            }
            td[class="img-flex"] img{
                width:100% !important;
                height:auto !important;
            }
            td[class="aligncenter"]{text-align:center !important;}
            th[class="flex"]{
                display:block !important;
                width:100% !important;
            }
            td[class="wrapper"]{padding:0 !important;}
            td[class="holder"]{padding:30px 15px 20px !important;}
            td[class="nav"]{
                padding:20px 0 0 !important;
                text-align:center !important;
            }
            td[class="h-auto"]{height:auto !important;}
            td[class="description"]{padding:30px 20px !important;}
            td[class="i-120"] img{
                width:120px !important;
                height:auto !important;
            }
            td[class="footer"]{padding:5px 20px 20px !important;}
            td[class="footer"] td[class="aligncenter"]{
                line-height:25px !important;
                padding:20px 0 0 !important;
            }
            tr[class="table-holder"]{
                display:table !important;
                width:100% !important;
            }
            th[class="thead"]{display:table-header-group !important; width:100% !important;}
            th[class="tfoot"]{display:table-footer-group !important; width:100% !important;}
        }
    </style>
</head>
<body style="margin:0; padding:0;" bgcolor="#eaeced">
<table style="min-width:320px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#eaeced">
    <!-- fix for gmail -->
    <tr>
        <td class="hide">
            <table width="600" cellpadding="0" cellspacing="0" style="width:600px !important;">
                <tr>
                    <td style="min-width:600px; font-size:0; line-height:0;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="wrapper" style="padding:0 10px;">
            <!-- module 1 -->
            <!-- module 2 -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#eaeced">
                        <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="img-flex"><img src="{{@$post->image . @$project->name}}" style="vertical-align:top;" width="600" height="306" alt="" /></td>
                            </tr>
                            <tr>
                                <td class="holder" style="padding:20px 60px 52px;" bgcolor="#f9f9f9">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="title" align="center" style="font:35px/38px Arial, Helvetica, sans-serif; color:#292c34; padding:0 0 24px;">
                                                {{@$post->title . @$project->name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="font:bold 16px/25px Arial, Helvetica, sans-serif; color:#888; padding:0 0 23px; ">
                                                <div style="height: 115px; margin-bottom: 10px; overflow: hidden;">{!! @$post->content . @$project->desc !!}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 20px;">
                                                <table width="134" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td class="btn" align="center" style="font:12px/14px Arial, Helvetica, sans-serif; color:#f8f9fb; text-transform:uppercase; mso-padding-alt:12px 10px 10px; border-radius:2px;" bgcolor="#7bb84f">
                                                            <a target="_blank" style="text-decoration:none; color:#f8f9fb; display:block; padding:12px 10px 10px;" href="{{$actionUrl}}">{{$actionText}}</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td height="28"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#eaeced">
                        <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="footer" style="padding:0 0 10px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr class="table-holder">
                                            <th class="tfoot" width="400" align="left" style="vertical-align:top; padding:0;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td class="aligncenter" style="font:12px/16px Arial, Helvetica, sans-serif; color:#797c82; padding:0 0 10px; text-align:center;">
                                                            <a target="_blank" style="text-decoration:underline; color:#797c82;" href="sr_unsubscribe">Unsubscribe</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- fix for gmail -->
    <tr>
        <td style="line-height:0;"><div style="display:none; white-space:nowrap; font:15px/1px courier;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></td>
    </tr>
</table>
</body>
</html>