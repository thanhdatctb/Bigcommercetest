<table border="1">
    <tr>
        <th>SKU</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
    </tr>
   @foreach($products as $product)
       <tr>
           <td>{{$product["sku"]}}</td>
           <td>{{$product["name"]}}</td>
           <td>{!!$product["description"]!!}</td>
           <td>
               <table border="1" cellspacing="0">
                   @foreach(\App\Http\Controllers\ProductController::findImageById($product["id"]) as $image)
                       <tr>
                           <td><img src="{{$image->url_tiny}}"></td>
                       </tr>
                   @endforeach
               </table>
           </td>
       </tr>
       @endforeach
</table>
