<?php

namespace App\Http\Controllers;
use Cart;

class ExamplePagesController extends Controller
{
    /**
     * Display the pricing page
     *
     * @return \Illuminate\View\View
     */
    public function pricing()
    {
        //return view('/');
    }

         public function cartshopping()
    {
    
        $products = \Cart::content();
  
            return view('cart.cartshopping');
    }

   

    /**
     * Display the lock page
     *
     * @return \Illuminate\View\View
     */
    public function lock()
    {
        return view('pages.example_pages.lock');
    }

    /**
     * Display the rtl support page
     *
     * @return \Illuminate\View\View
     */
    public function rtlSupport()
    {
        return view('pages.example_pages.language');
    }

    /**
     * Display the rtl support page
     *
     * @return \Illuminate\View\View
     */
    public function error()
    {
        return view('pages.example_pages.error');
    }

    /**
     * Display the timeline page
     *
     * @return \Illuminate\View\View
     */
    public function timeline()
    {
        return view('pages.example_pages.timeline');
    }

    /**
     * Display the widgets page
     *
     * @return \Illuminate\View\View
     */
    public function widgets()
    {
        return view('pages.widgets');
    }

    /**
     * Display the charts page
     *
     * @return \Illuminate\View\View
     */
    public function charts()
    {
        return view('pages.charts');
    }

    /**
     * Display the calendar page
     *
     * @return \Illuminate\View\View
     */
    public function calendar()
    {
        return view('pages.calendar');
    }
}
