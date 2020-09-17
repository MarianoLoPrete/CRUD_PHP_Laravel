<?php

namespace App\Http\Controllers;

use App\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Metodo paginador que limita la vista de 5 elementos de lista
        $datos['empleados']=Empleados::paginate(6);

        return view('empleados.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valildador de campos en forumalario. Campos requeridos
        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'foto' => 'required|max:10000|mimes:jpeg,png,jpg,gif',
        ];
        $Mensaje=["required"=>'El :attribute es requerido'];

        //Se validan los campos q se estan enviando al metodo store
        $this->validate($request,$campos,$Mensaje);

        // $datosEmpleado=request()->all();
        $datosEmpleado=request()->except('_token');

        if($request->hasFile('foto')){

            $datosEmpleado['foto']=$request->file('foto')->store('uploads','public');

        }

        Empleados::insert($datosEmpleado);

        //return response()->json($datosEmpleado);
        return redirect('empleados')->with
        ('Mensaje','Empleado agregado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //busca el id y trae toda la info q tiene
        $empleado = Empleados::findOrFail($id);

        //retorno la variable empleado con el metodo compact a la vista edit
        return view('empleados.edit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //valildador de campos en forumalario. Campos requeridos
        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email'

        ];

        if($request->hasFile('foto')){

           $campos+= ['foto' => 'required|max:10000|mimes:jpeg,png,jpg,gif'];
        }

        $Mensaje=["required"=>'El :attribute es requerido'];


        //Se validan los campos q se estan enviando al metodo store
        $this->validate($request,$campos,$Mensaje);

        //Recepciono todos los datos y excluyo el token q laravel ya usa por defecto
        $datosEmpleado=request()->except(['_token','_method']);

        if($request->hasFile('foto')){

            $empleado = Empleados::findOrFail($id);

            Storage::delete('public/'.$empleado->foto);

            $datosEmpleado['foto']=$request->file('foto')->store('uploads','public');

        }

        //actualiza datos segun el id
        Empleados::where('id','=',$id)->update($datosEmpleado);

        // //busca el id y trae toda la info q tiene
        // $empleado = Empleados::findOrFail($id);
        // //retorno la variable empleado con el metodo compact a la vista edit
        // return view('empleados.edit',compact('empleado'));

        return redirect('empleados')->with
        ('Mensaje','Empleado modificado con éxito!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $empleado = Empleados::findOrFail($id);

        if(Storage::delete('public/'.$empleado->foto)){
            Empleados::destroy($id);
        }

        return redirect('empleados')->with
        ('Mensaje','Empleado eliminado con éxito!');
    }
}
