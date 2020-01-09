<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="container">
    <form method="post">
        @csrf
        <div class="form-group">
            <label>SKU</label>
            <input type="text" class="form-control" name="sku" readonly value="{{$product['sku']}}">
        </div>
         <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name ="name"value="{{$product['name']}}" placeholder="Name">
        </div>
        <!--Material textarea-->
        <div class="md-form">
            <label for="form7 form-control">Description</label>
            <textarea id="form7" class="md-textarea form-control" rows="3" name="description">
                {{$product["description"]}}
            </textarea>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>