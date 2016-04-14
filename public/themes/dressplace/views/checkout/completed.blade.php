@extends('dressplace::layout')

@section('content')
<!-- BEGIN: PAGE CONTENT -->
                    <div class="c-shop-order-complete-1 c-content-bar-1 c-align-left c-bordered c-theme-border c-shadow">
                        <div class="c-content-title-1 text-center">
                            <h3 class="c-center c-font-uppercase c-font-bold">Checkout Completed</h3>
                            <div class="c-line-center c-theme-bg"></div>
                        </div>
                        <div class="c-theme-bg text-center">
                            <p class="c-message c-center c-font-white c-font-20 c-font-sbold">
                                <i class="fa fa-check"></i> Thank you. Your order has been received. </p>
                        </div>
                        <!-- BEGIN: ORDER SUMMARY -->
                        <div class="row c-order-summary c-center text-center">
                            <ul class="c-list-inline list-inline">
                                <li>
                                    <h3>Order Number</h3>
                                    <p>#12345</p>
                                </li>
                                <li>
                                    <h3>Date Purchased</h3>
                                    <p>August 26, 2015</p>
                                </li>
                                <li>
                                    <h3>Total Payable</h3>
                                    <p>$95.00</p>
                                </li>
                                <li>
                                    <h3>Payment Method</h3>
                                    <p>Direct Bank Transfer</p>
                                </li>
                            </ul>
                        </div>
                        <!-- END: ORDER SUMMARY -->
                        <!-- BEGIN: BANK DETAILS -->
                        <div class="c-bank-details c-margin-t-30 c-margin-b-30">
                            <p class="c-margin-b-20">Make your payment directly into our account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.</p>
                            <h3 class="c-margin-t-40 c-margin-b-20 c-font-uppercase c-font-22 c-font-bold">OUR BANK DETAILS</h3>
                            <h3 class="c-border-bottom">Account Name : &nbsp;
                                <span class="c-font-thin">Themehats</span>
                            </h3>
                            <ul class="c-list-inline list-inline">
                                <li>
                                    <h3>Account Number</h3>
                                    <p>12345678901234567</p>
                                </li>
                                <li>
                                    <h3>Sort Code</h3>
                                    <p>123</p>
                                </li>
                                <li>
                                    <h3>Bank</h3>
                                    <p>Bank Name</p>
                                </li>
                                <li>
                                    <h3>BIC</h3>
                                    <p>12345</p>
                                </li>
                            </ul>
                        </div>
                        <!-- END: BANK DETAILS -->
                        <!-- BEGIN: ORDER DETAILS -->
                        <div class="c-order-details">
                            <div class="c-border-bottom hidden-sm hidden-xs">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3 class="c-font-uppercase c-font-16 c-font-grey-2 c-font-bold">Product</h3>
                                    </div>
                                    <div class="col-md-5">
                                        <h3 class="c-font-uppercase c-font-16 c-font-grey-2 c-font-bold">Description</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <h3 class="c-font-uppercase c-font-16 c-font-grey-2 c-font-bold">Unit Price</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <h3 class="c-font-uppercase c-font-16 c-font-grey-2 c-font-bold">Total</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- BEGIN: PRODUCT ITEM ROW -->
                            <div class="c-border-bottom c-row-item">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 c-image">
                                        <div class="c-content-overlay">
                                            <div class="c-overlay-wrapper">
                                                <div class="c-overlay-content">
                                                    <a href="#" class="btn btn-md c-btn-grey-1 c-btn-uppercase c-btn-bold c-btn-border-1x c-btn-square">Explore</a>
                                                </div>
                                            </div>
                                            <div class="c-bg-img-top-center c-overlay-object" data-height="height">
                                                <img width="100%" class="img-responsive" src="http://shooky.ddns.net/images/products/79/2048//%D0%BC%D1%8A%D0%B6%D0%BA%D0%B8-%D1%82%D0%B5%D0%BD%D0%B8%D1%81%D0%BA%D0%B8-%D0%B1%D1%8F%D0%BB%D0%B0-%D1%82%D0%B5%D0%BD%D0%B8%D1%81%D0%BA%D0%B0-jack-davis-print-emoticon-1.jpg"> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-8">
                                        <ul class="c-list list-unstyled">
                                            <li class="c-margin-b-25">
                                                <a href="#" class="c-font-bold c-font-22 c-theme-link">Winter Coat</a>
                                            </li>
                                            <li class="c-margin-b-10">Color: Blue</li>
                                            <li>Size: S</li>
                                            <li>Quantity: x1</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="visible-xs-block c-theme-font c-font-uppercase c-font-bold">Unit Price</p>
                                        <p class="c-font-sbold c-font-uppercase c-font-18">$20.00</p>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="visible-xs-block c-theme-font c-font-uppercase c-font-bold">Total</p>
                                        <p class="c-font-sbold c-font-18">$20.00</p>
                                    </div>
                                </div>
                            </div>
                            <!-- END: PRODUCT ITEM ROW -->
                            <!-- BEGIN: PRODUCT ITEM ROW -->
                            <div class="c-border-bottom c-row-item">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 c-image">
                                        <div class="c-content-overlay">
                                            <div class="c-overlay-wrapper">
                                                <div class="c-overlay-content">
                                                    <a href="#" class="btn btn-md c-btn-grey-1 c-btn-uppercase c-btn-bold c-btn-border-1x c-btn-square">Explore</a>
                                                </div>
                                            </div>
                                            <div class="c-bg-img-top-center c-overlay-object" data-height="height">
                                                <img width="100%" class="img-responsive" src="http://shooky.ddns.net/images/products/79/2048//%D0%BC%D1%8A%D0%B6%D0%BA%D0%B8-%D1%82%D0%B5%D0%BD%D0%B8%D1%81%D0%BA%D0%B8-%D0%B1%D1%8F%D0%BB%D0%B0-%D1%82%D0%B5%D0%BD%D0%B8%D1%81%D0%BA%D0%B0-jack-davis-print-emoticon-1.jpg"> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-8">
                                        <ul class="c-list list-unstyled">
                                            <li class="c-margin-b-25">
                                                <a href="#" class="c-font-bold c-font-22 c-theme-link">Sports Wear</a>
                                            </li>
                                            <li class="c-margin-b-10">Color: Blue</li>
                                            <li>Size: S</li>
                                            <li>Quantity: x1</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="visible-xs-block c-theme-font c-font-uppercase c-font-bold">Unit Price</p>
                                        <p class="c-font-sbold c-font-uppercase c-font-18">$15.00</p>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="visible-xs-block c-theme-font c-font-uppercase c-font-bold">Total</p>
                                        <p class="c-font-sbold c-font-18">$30.00</p>
                                    </div>
                                </div>
                            </div>
                            <!-- END: PRODUCT ITEM ROW -->
                            <div class="c-row-item c-row-total c-right text-right">
                                <ul class="c-list list-unstyled">
                                    <li>
                                        <h3 class="c-font-regular c-font-22">Subtotal : &nbsp;
                                            <span class="c-font-dark c-font-bold c-font-22">$80.00</span>
                                        </h3>
                                    </li>
                                    <li>
                                        <h3 class="c-font-regular c-font-22">Shipping Fee : &nbsp;
                                            <span class="c-font-dark c-font-bold c-font-22">$15.00</span>
                                        </h3>
                                    </li>
                                    <li>
                                        <h3 class="c-font-regular c-font-22">Grand Total : &nbsp;
                                            <span class="c-font-dark c-font-bold c-font-22">$95.00</span>
                                        </h3>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END: ORDER DETAILS -->
                        <!-- BEGIN: CUSTOMER DETAILS -->
                        <div class="c-customer-details row" data-auto-height="true">
                            <div class="col-md-6 col-sm-6 c-margin-t-20">
                                <div data-height="height">
                                    <h3 class=" c-margin-b-20 c-font-uppercase c-font-22 c-font-bold">Customer Details</h3>
                                    <ul class="list-unstyled">
                                        <li>Name: John Doe</li>
                                        <li>Phone: 800 123 3456</li>
                                        <li>Fax: 800 123 3456</li>
                                        <li>Email:
                                            <a href="mailto:info@jango.com" class="c-theme-color">info@jango.com</a>
                                        </li>
                                        <li>Skype:
                                            <span class="c-theme-color">jango</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 c-margin-t-20">
                                <div data-height="height">
                                    <h3 class=" c-margin-b-20 c-font-uppercase c-font-22 c-font-bold">Billing Address</h3>
                                    <ul class="list-unstyled">
                                        <li>John Doe</li>
                                        <li> 25, Lorem Lis Street, Orange
                                            <br /> California, US
                                            <br /> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END: CUSTOMER DETAILS -->
                    </div>
            <!-- END: PAGE CONTENT -->
@endsection