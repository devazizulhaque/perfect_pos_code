@extends('admin.master')

@section('title')
  All Purchase
@endsection

@section('css')
  <style>
    .serchicon{
      position: absolute;
      z-index: 1;
      border: 1px solid #ccc;
      background: rgb(219, 219, 219);
      border-top-right-radius: 0px;
      border-bottom-right-radius: 0px;
      padding-bottom: 3px;
    }
    .serchicon:hover{
      cursor: pointer;
      background: rgb(219, 219, 219);
    }
    .inputfield{
      position: relative
    }
    .searchfield{
      margin-left: 35px;
    }
  </style>
@endsection

@section('body')
<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">All Purchase</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span><a href="{{ route('dashboard') }}">Dashboard</a></span></li>
            <li><span>Purchase</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
    </div>
</header>
<!-- start: page -->
<div class="row">
  <div class="col">
    <div class="card card-modern">
      <div class="card-body m-0 p-0">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>All Product</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                              <div class="serchicon btn"><i class="fa-solid fa-magnifying-glass pt-2"></i></div>
                              <div class="inputfield"><input type="text" class="form-control searchfield" id="inputfield" name="search" placeholder="Search Product Name or SKU"></div>
                            </form>
                            <div id="product_list">
                              <div class="row pt-3">
                                @foreach ($products as $product)
                                <div class="col-sm-6 col-md-3 mb-4">
                                    <div class="card card-modern card-modern-alt-padding" style="height: 300px">
                                        <div class="card-body bg-light p-0" style="height: 300px">
                                            <div class="image-frame mb-2">
                                                <div class="image-frame-wrapper">
                                                    <a href="javascript:void(0);" id="product" data-id="{{ $product->id }}" class="product productSelect"><img src="{{ asset($product->image) }}" class="img-fluid" alt="Product Short Name" /></a>
                                                </div>
                                            </div>
                                            <small><a href="javascript:void(0);" id="product" data-id="{{ $product->id }}" class="ecommerce-sidebar-link text-color-grey text-color-hover-primary text-decoration-none product productSelect">{{ $product->category->category_name }}</a></small>
                                            <h4 class="text-4 line-height-2 mt-0 mb-2"><a href="javascript:void(0);" id="product" data-id="{{ $product->id }}" class="ecommerce-sidebar-link text-color-dark text-color-hover-primary text-decoration-none product productSelect" style="color: #000;">{{ $product->product_name }}</a></h4>
                                            <div class="product-price">
                                                <div class="sale-price">${{ $product->sale_price }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                        
                        </div>
                        <div class="card-body pt-4">
                          @foreach($errors->all() as $error)
                            <span class="text-danger">{{ $error }}</span>
                            <br>
                          @endforeach
                            <form action="{{ route('purchase.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 pb-3">
                                        <label class="pt-2" style="font-size:15px"><strong>Supplier Select</strong></label>
                                        <select class="select2 form-select shadow-none" name="supplier_id" id="supplierId" style="width: 100%; height: 36px" data-toggle="select2" data-placeholder="Select a supplier" required>
                                          <option value="">Select a Supplier</option>
                                          @foreach ($suppliers as $supplier)
                                          <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 pb-3">
                                        <label class="pt-2" style="font-size:15px"><strong>Warehouse Select</strong></label>
                                        <select class="select2 form-select shadow-none" name="warehouse_id" id="warehouseId" style="width: 100%; height: 36px" data-toggle="select2" data-placeholder="Select a warehouse" required>
                                          <option>Select</option>
                                          @foreach ($warehouses as $warehouse)
                                          <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                <table class="table nowrap table-borderless table_field table-sm" id="table_field">
                                    <thead>
                                        <tr style="background: rgb(45, 45, 206); color:white">
                                            <th style="width: 30%">Product Name </th>
                                            <th style="width: 12%">Quantity </th>
                                            <th style="width: 16%">Sell price</th>
                                            <th style="width: 16%">Price</th>
                                            <th style="width: 16%">Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items" class="items">
        
                                    </tbody>
                                    <tfoot>
                                        <tr style="height: 150px">
                                            <td colspan="">
                                                <p class="font-weight-bold">Total</p>
                                                <input type="text" class="form-control" id="total_" name="total_price"
                                                    readonly>
                                            </td>
                                            <td>
                                              <p class="font-weight-bold">Discount</p>
                                              <input type="text" class="form-control" id="discount" value="0.00"
                                                  name="discount">
                                          </td>
                                            {{-- <td>
                                                <p class="font-weight-bold">Paid By</p>
                                                <select class="form-contro bg-secondary pt-2 pb-2 text-center text-white" id="paidby" name="payment_type">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Card">Card</option>
                                                    <option value="Mobile Banking">Mobile Banking</option>
                                                </select>
                                            </td> --}}
                                            <td colspan="2">
                                                <p class="font-weight-bold">Amount Paid</p>
                                                <input type="text" class="form-control" id="pay_" name="paid_amount" required>
                                            </td>
                                            <td colspan="2">
                                                <p class="font-weight-bold">Due/Return</p>
                                                <div id="purchase_due">
                                                  <input type="text" class="form-control" value="0" id="due" name="due_amount" readonly>
                                                </div>
                                                <input type="hidden" class="form-control" value="0" id="previous_due" readonly>
                                            </td>
                                    
                                        
                                            
                                        </tr>
                                        <tr>
                                          <td colspan="">
                                              <p class="font-weight-bold">Buying Date</p>
                                              <input type="date" name="purchase_date" class="form-control" id="dateInput" required>
                                          </td>
                                          <td colspan="2">
                                            <p class="font-weight-bold">Carrying cost</p>
                                            <input type="tel" name="carrying_cost" class="form-control" id="carrying_cost" required>
                                          </td>
                                          <td colspan="4">
                                            <p class="font-weight-bold">Note</p>
                                            <textarea name="note" class="form-control" id="" cols="30" rows="1"></textarea>
                                          </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br />
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end: page -->
@endsection

@section('js')
<script>

  $(document).on('keyup', '#inputfield', function () {
    let inputField = $(this).val();
    $.ajax({
        url: '/get-product',
        method: 'POST',
        data: {
            inputfield: inputField,
            _token: "{{ csrf_token() }}",
        },
        success: function (data) {
            var result = '';
            result += '<div class="row pt-3">';
                $.each(data, function(key, value){
                    result += '<div class="col-sm-6 col-md-3 mb-4">';
                    result += '<div card card-modern card-modern-alt-padding" style="height: 300px">';
                    result += '<div class="card-body bg-light" style="height: 300px">';
                    result += '<div class="image-frame mb-2">';
                    result += '<div class="image-frame-wrapper">';
                    result += '<a href="javascript:void(0);" id="product" data-id="'+value.id+'" class="product productSelect"><img src="{{ asset('') }}'+value.image+'" class="img-fluid" alt="Product Short Name" /></a>';
                    result += '</div>';
                    result += '</div>';
                    result += '<h4 class="text-4 line-height-2 mt-0 mb-2"><a href="javascript:void(0);" id="product" data-id="'+value.id+'" class="ecommerce-sidebar-link text-color-dark text-color-hover-primary text-decoration-none product productSelect" style="color: #000;">'+value.product_name+'</a></h4>';
                    result += '<div class="product-price">';
                    result += '<div class="sale-price">$'+value.sale_price+'</div>';
                    result += '</div>';
                    result += '</div>';
                    result += '</div>';
                    result += '</div>';
                });
                result += '</div>';
                $('#product_list').html(result);
        }
    })
  })


  $(document).on('change', '#supplierId', function () {
    var supplierId = $(this).val();
    $.ajax({
        url: '/get-purchase-due',
        method: 'POST',
        data: {
            supplier_id: supplierId,
            _token: "{{ csrf_token() }}",
        },
        success: function (data) {
            $('#previous_due').val(data);
            $('#due').val(data);
        }
    })
  });


  
  $(document).on('click', '#product', function () {
    var product_id = $(this).attr('data-id');
    var supplierId = $('#supplierId').val();

    if (!supplierId) {
      Swal.fire({
        position: 'top-end',
        icon: 'warning',
        title: 'Select a Supplier First',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 1800,
        customClass: {
            container: 'custom-swal-alert',
            title: 'custom-swal-title',
            text: 'custom-swal-text',
            popup: 'popup-class',
        }
      });
    }
    else{
      let n = ($('#items tr').length - 0) + 1;
      let n1 = ($('#items1 tr').length - 0) + 1;
      if ($(".item-in-cart").toArray().map(el => el.getAttribute("data-id")).includes(product_id)) {
        Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'Already Added',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1800
        });
      } 
      else {
        $.get("/get-product-by-id/" + product_id, function(data) {
          var tr = $('#items').append(`<tr class="item-in-cart" data-id="${data.id}">
            <td><input type="text" value="${data.product_name}" class="form-control cat_name" id="product_name" name="product_name[]" readonly><input type="hidden" value="${data.id}" name="product_id[]"> </td>
            
            <td><span><input type="number" value="1" min="1" class="form-control quantity" id="quantity" name="quantity[]" required>
            </span></td>
            <td><span><input type="tel" class="form-control unit_price" id="unit_price" value="${data.sale_price}" name="unit_price[]" required>
            </span></td>
            <td><input type="text" class=" form-control price"  id="price" name="buying_price[]"></td>

            <td id="grandtotal"><input type="text"  class="item-in-cart-cost form-control getsubtotal" name="sub_total[]" id="grandtotal" readonly></td>

            <td><button name="remove" class="btn btn-danger btn-sm remove" id="remove"><i class="fas fa-eraser"></i> </button></td>
            </tr>`);
          cartTotal();
          var tr = $('#items1').append(`<tr data-id="${product_id}">
            <td style="color: #000; width: 10px">${n1}</td>
            <td style="color: #000; width: 20px">${data.product_name}</td>
            <td style="color: #000; width: 20px">${Number(data.price).toFixed(2)}</td>
            </tr>`);
        });

        $('.items').delegate(".remove", "click", function() {
          var rowIndex = $(this).closest('tr').prop('rowIndex');
          $('.items tr').filter(function() {
            return this.rowIndex === rowIndex;
          }).remove();
          cartTotal();
        });
      }
    }
  });

  $(function() {
    $(document).on('keyup', '#price, .quantity', function() { // Updated to include '.quantity'
      let quantity = $(this).closest('tr').find('.quantity').val();
      let price = $(this).closest('tr').find('.price').val();
      let grandtotal = quantity * price;
      let getsubtotal = '<input type="" value="' + grandtotal + '" class="item-in-cart-cost form-control getsubtotal" name="sub_total[]" id="grandtotal" readonly>';
      $(this).closest('tr').find('#grandtotal').html(getsubtotal);

      cartTotal();
      $('#discount').trigger('keyup'); // Trigger keyup event on the discount input field
    });
  });

  function cartTotal() {
    let count = $(".item-in-cart-cost").length;
    if (count > 0) {
      let totalCost = $(".item-in-cart-cost").toArray().map(el => $(el).val()).reduce((x, y) => Number(x) +
        Number(y));

      $('#total_').val(Number(totalCost).toFixed(2));
      $('#total_').val(Number(totalCost).toFixed(2));

      $('#__total__').html(Number(totalCost).toFixed(2));

      updateDue();
    } else {
      let totalCost = 0;
      $('#total_').val(Number(totalCost).toFixed(2));

      $('#subtotal').html(Number(totalCost).toFixed(2));
      $('#__total__').html(Number(totalCost).toFixed(2));
      
      updateDue();
    }
  }

  $(function() {
    $('#total_, #discount, #pay_').keyup(function() {
         var value1 = $(".item-in-cart-cost").toArray().map(el => $(el).val()).reduce((x, y) => Number(x) + Number(y));;
        var value2 = $('#discount').val();

        if (value2 / 10 >= 1) {
            if (value1 !== '' && value2 !== '') {
                value1 = parseFloat(value1);
                value2 = parseFloat(value2);
                var total_ = value1 - value2 ;
        
                $('#discount__').html(Number(value2).toFixed(2));
                $('#total_').val(Number(total_).toFixed(2));
                $('#__total__').html(Number(total_).toFixed(2));

                updateDue();
            }
        }
        else{
            if (value1 !== '' && value2 !== '') {
                value1 = parseFloat(value1);
                value2 = parseFloat(value2);
                var total_ = value1 - value2;
        
                $('#discount__').html(Number(value2).toFixed(2));
                $('#total_').val(Number(total_).toFixed(2));
                $('#__total__').html(Number(total_).toFixed(2));

                updateDue();
            }
        }
    });
  });

function updateDue(){
  var value1 = $("#total_").val();
  var value2 = parseFloat($('#pay_').val()) || 0;
  var value3 = parseFloat($('#previous_due').val()) || 0;
  var value4 = parseFloat(value1)
  console.log(value3);
  if (value2 > 0) {
    var total = value1 - value2 + value3
    let purchaseDue = '<input type="" value="' + total + '" class="form-control form-custom" name="due_amount" readonly>';
    $('#purchase_due').html(purchaseDue); 
  }
  else{
    var total = value4 + value3
    let purchaseDue = '<input type="" value="' + total + '" class="form-control form-custom" name="due_amount" readonly>';
    $('#purchase_due').html(purchaseDue); 
  }
}



var today = new Date();

// Format the date as YYYY-MM-DD
var year = today.getFullYear();
var month = (today.getMonth() + 1).toString().padStart(2, '0');
var day = today.getDate().toString().padStart(2, '0');
var formattedDate = `${year}-${month}-${day}`;

// Set the value of the date input to today's date
document.getElementById('dateInput').value = formattedDate;

</script>
@endsection
