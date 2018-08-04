<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		return view("pdf.info");
	}
}
