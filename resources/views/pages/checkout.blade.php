@extends('layouts.checkout')

@section('title', 'Checkout')

@section('content')
<main>
    <section class="section-details-header"> </section>
    <section class="section-details-content">
      <div class="container">
        <div class="row">
          <div class="col ">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item">Paket Travel</li>
                <li class="breadcrumb-item" aria-current="page">Details</li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 pl-lg-0">
            <div class="card card-details">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              <h1>Who is Going?</h1>
              <p>Trip to {{$item->travel_package->title}}, {{$item->travel_package->location}}</p>
              <div class="attendee">
                <table class="table table-responsive-sm text-center">
                  <thead>
                    <tr>
                      <td>Picture</td>
                      <td>Name</td>
                      <td>Nationality</td>
                      <td>Visa</td>
                      <td>Passport</td>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($item->details as $detail)
                    <tr>
                        <td>
                          <img src="https://ui-avatars.com/api/?name={{ $detail->username}}" class="rounded-circle" height="60" alt="">
                        </td>
                        <td class="align-middle">
                          {{$detail->username}}
                        </td>
                        <td class="align-middle">
                            {{$detail->nationality}}
                        </td>
                        <td class="align-middle">
                            {{$detail->is_visa ? '30 Days': 'N/A'}}
                        </td>
                        <td class="align-middle">
                            {{\Carbon\Carbon::createFromDate($detail->doe_passport) > \Carbon\Carbon::now() ? 'Active' : 'Inactive'}}
                        </td>
                        <td class="align-middle">
                          <a href="{{ route('checkout-remove', $detail->id)}}">
                            <img src="{{ url('frontend/images/remove.png')}}" alt="">
                          </a>
                        </td>
                      </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Visitor</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div class="member mt-3">
                <h2>Add Member</h2>
                <form class="row g-2" action="{{ route('checkout-create', $item->id)}}" method="POST">
                    @csrf
                  <div class="col-auto">
                    <label for="username" class="visually-hidden form-label">Name</label>
                    <input name="username" type="text" class="form-control mb-2 me-sm-2" id="username" required placeholder="Username">
                  </div>
                  <div class="col-auto">
                    <label for="nationality" class="visually-hidden form-label">Nationality</label>
                    <input name="nationality" type="text" class="form-control mb-2 me-sm-2" style="width: 50px" required id="nationality" placeholder="Nationality">
                  </div>
                  <div class="col-auto">
                    <label for="is_visa" class="visually-hidden form-label">Visa</label>
                    <select class="form-select" name="is_visa" id="is_visa" class="custom-select mb-2 me-sm-2" required>
                      <option value="" selected>VISA</option>
                      <option value="1">30 Days</option>
                      <option value="0">N/A</option>
                    </select>
                  </div>
                  <div class="col-auto">
                    <label for="doe_passport" class="visually-hidden">DOE Passport</label>
                    <div class="input-group mb-2 me-sm-2">
                      <input type="text" class="form-control datepicker"id="doe_passport" name="doe_passport" placeholder="DOE Passport">
                    </div>
                  </div>
                  <div class="col-auto">
                    <button class="btn btn-add-now mb-2 px-2">
                      Add Now
                    </button>
                  </div>

                </form>
                <h3 class="mt-2 mb-0">Note</h3>
                <p class="disclaimer">You are only to Invite member that has registered in Nomads.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-details card-right">

              <h2>Checkout Informations</h2>
              <table class="trip-information">
                <tr>
                  <th width="50%">Members</th>
                  <td width="50%" class="text-right">
                    {{ $item->details->count()}} Person
                  </td>
                </tr>
                <tr>
                  <th width="50%">Additional VISA</th>
                  <td width="50%" class="text-right">
                   $ {{$item->additional_visa}},00
                  </td>
                </tr>
                <tr>
                  <th width="50%">Trip Price</th>
                  <td width="50%" class="text-right">
                    ${{$item->travel_package->price}}.00/Person
                  </td>
                </tr>
                <tr>
                  <th width="50%">Sub Total</th>
                  <td width="50%" class="text-right">
                    ${{$item->transaction_total }},00
                  </td>
                </tr>
                <tr>
                  <th width="50%">Total (+Unique Codes)</th>
                  <td width="50%" class="text-right text-total">
                    <span class="text-blue">${{$item->transaction_total }},</span>
                    <span class="text-orang">{{ mt_rand(0,99)}}</span>
                  </td>
                </tr>
              </table>
              <hr>
              <h2>Payment Instructions</h2>
              <p class="payment-instructions">
                Pleas Complete the payment before you
                  continue the trip
              </p>
              <div class="bank">
                <div class="bank-item pb-3">
                  <img src="/frontend/images/ic_bank.png" alt=" " class="bank-image">
                  <div class="description">
                    <h3>PT Nomads ID</h3>
                    <p>0829 0999 8390
                      <br>
                      BANK Central Asia
                    </p>


                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <div class="bank">
                <div class="bank-item pb-3">
                  <img src="/frontend/images/ic_bank.png" alt=" " class="bank-image">
                  <div class="description">
                    <h3>PT Nomads ID</h3>
                    <p>0829 0999 8390
                      <br>
                      BANK Central Asia
                    </p>


                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <hr>
            </div>
            <div class="join-container">
              <a href="{{route('checkout-success', $item->id)}}" class="btn d-grid gap-2 btn-join-now mt-3 py-2">
                I Have Made Payment
              </a>
            </div>
            <div class="text-center mt-3">
              <a href="{{route('detail', $item->travel_package->slug)}}" class="text-muted">
                Cancel Booking
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>


  </main>
@endsection

@push('prepend-style')
<link rel="stylesheet" href="{{ url('frontend/libraries/gijgo/css/gijgo.min.css') }}">
@endpush

@push('addon-script')
<script src="{{ url('frontend/libraries/gijgo/js/gijgo.min.js')}}"></script>
  <script>
    $(document).ready(function(){

      $('.datepicker').datepicker({
        format:'yyyy-mm-dd',
        uiLibrary:'bootstrap4',
        icons:{
          rightIcon:'<img src="{{ url('frontend/images/kalender.png')}}" />'
        }
      })
    })
  </script>
  </script>
@endpush
