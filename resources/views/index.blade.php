<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>LaraCRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-light" href="#">Products</a>
                </div>
            </div>
        </div>
    </nav>
   
    <div class="container mt-5 col-6 md-5">
        <div class="card p-5">
            <div class="card-title">
                <h1>Add the product data here:</h1>
            </div>
            <div class="card-body">
                <form onsubmit="return false" method="POST" id="my-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <input type="hidden" name="type" value="insert">
                    <input type="hidden" name="hidden_img" id="hidden_id">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter name">
                    </div>

                    <div class="mb-3">
                        <label for="description">description</label>
                        <input type="text" class="form-control" name="description" id="description"
                            placeholder="Enter description">
                    </div>

                    <div class="mb-3">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image"
                            placeholder="Enter Image">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary mt-3" id="submit"
                            value="Add Student">Submit</button>
                    </div>
                </form>
            </div>
            <span id="output"></span>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Product Table</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Name</th>
                    <th>description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbody">   
            </tbody>
            </table>
<div class="row">
    <div class="col-4">
      {{ $products->links() }}
    </div>
</div>        
</body>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        listing()
        $("#my-form").submit(function(e) {
            listing()
            $.ajax({
                type: "POST",
                url: "{{ route('product.productview') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $('#my-form')[0].reset();
                    $('#output').text(data.res);
                      listing()
                },

                error: function(e) {
                    console.log("error", e);
                }
            })
        })

        function listing() {
        console.log("We have reached the listing!");
            $.ajax({
                type: "GET",
                url: "{{ route('product.listing') }}",
                success: function(data) {
                    $("#tbody").html(data['tbody']); // Render the product data
                },
        
                error: function(e) {
                    console.log("error", e);
                }
            })
        }


            $(document).on('click', '.edit', function () {
            let editId = this.getAttribute('id');
            $.ajax({
                type: "POST",
                data:{ 
                    "_token": "{{ csrf_token() }}",
                    'editId':editId,
                    'type': 'edit'
                },
                url: "{{ route('product.edit') }}",
                success: function(data) {
                    let productData = data.singleProductData;
                    console.log('productData', productData);
                    $('#name').val(productData['name'])
                    $('#hidden_id').val(productData['id'])
                    $('#description').val(productData['description'])
                    $('#hidden_img').val(productData['image'])
                },
                error: function(e) {
                    console.log("error", e);
                }
            })
        })

            $(document).on('click', '.delete', function () {
            let deleteId = this.getAttribute('id');
            $.ajax({
                type: "POST",
                data:{ 
                    "_token": "{{ csrf_token() }}",
                    'deleteId':deleteId,
                    'type': 'delete'
                },
                url: "{{ route('product.delete') }}",
                success: function(data){
                    $('#output').text(data.res);
                    listing();
                },
                error: function(e) {
                    console.log("error", e);
                }
            })
            })
            })

   
</script>

</html>