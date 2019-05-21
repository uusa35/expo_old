<html>
<head>
<style>
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
</head>
<body>	

{!!$content!!}

<button onclick="myFunction()" class="no-print">Print</button>

<script>
function myFunction() {
    window.print();
}
</script>
</body>
</html>