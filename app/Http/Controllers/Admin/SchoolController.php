<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SchoolRequest;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$models = School::all();
		return view('admin.school.index', compact('models'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * @param SchoolRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SchoolRequest $request)
	{
		School::create($request->all());
		return redirect(route('school.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\School  $school
	 * @return \Illuminate\Http\Response
	 */
	public function show(School $school)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\School  $school
	 * @return \Illuminate\Http\Response
	 */
	public function edit(School $school)
	{
		$model = $school;
		$models = School::all();
		return view('admin.school.index', compact('models', 'model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\School  $school
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, School $school)
	{
		$school->update($request->all());
		return redirect(route('school.index'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\School $school
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(School $school)
	{
		$school->delete();
		return redirect(route('school.index'));
	}
}
