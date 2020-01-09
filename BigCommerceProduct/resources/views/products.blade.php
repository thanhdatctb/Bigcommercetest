<table border="1">
    <tr>
        <th>SKU</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Delete</th>
        <th>Edit</th>
    </tr>
   @foreach($products as $product)
       <tr>
           <td>{{$product["sku"]}}</td>
           <td>{{$product["name"]}}</td>
           <td>{!!$product["description"]!!}</td>
           <td>
               <table border="1" cellspacing="0">
                   @foreach($allImages[$product["id"]] as $image)
                       <tr>
                           <td><img src="{{$image["url_tiny"]}}"></td>
                       </tr>
                   @endforeach
               </table>
           </td>
           <td><a href="/delete/{{$product["id"]}}">Delete</a></td>
           <td><a href="/edit/{{$product["id"]}}">Edit</a> </td>
       </tr>
       @endforeach
</table>
