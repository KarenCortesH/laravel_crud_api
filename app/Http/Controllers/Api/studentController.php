<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //Listando Estudiantes
    public function index()
    {
        // Obtiene todos los estudiantes
        $students = Student::all();
        // Prepara los datos de respuesta JSON
        $data = [
            'students' => $students,
            'status' => 200
        ];

        // Retorna la respuesta JSON con los estudiantes y el estado 200 (OK)
        return response()->json($data, 200);
    }
    //Creando Estudiantes
    public function store(Request $request)
    {
        // Valida los datos recibidos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            // Prepara los datos de respuesta JSON con los errores de validación y el estado 400 (Bad Request)
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            // Retorna la respuesta JSON con los errores y el estado 400 (Bad Request)
            return response()->json($data, 400);
        }

        // Prepara los datos del estudiante a crear
        $studentData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ];

        // Crea un nuevo estudiante en la base de datos
        $student = Student::create($studentData);

        // Comprueba si el estudiante fue creado correctamente
        if (!$student) {
            // Prepara los datos de respuesta JSON con un mensaje de error y el estado 500 (Internal Server Error)
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            // Retorna la respuesta JSON con el mensaje de error y el estado 500 (Internal Server Error)
            return response()->json($data, 500);
        }

        // Prepara los datos de respuesta JSON con el estudiante creado y el estado 201 (Created)
        $data = [
            'student' => $student,
            'status' => 201
        ];

        // Retorna la respuesta JSON con el estudiante creado y el estado 201 (Created)
        return response()->json($data, 201);
    }

    //Eliminar Estudiante
    public function destroy($id)
    {
        //Aqui busco por el estudiante
        $student = Student::find($id);

        if(!$student){
        // Si no se encuentra el estudiante, prepara los datos de respuesta JSON con un mensaje de error y el estado 404 (Not Found)
        $data = [
            'message' => 'Estudiante no Encontrado',
            'status' => 404
        ];
        // Retorna la respuesta JSON con el mensaje de error y el estado 404 (Not Found)
        return response()->json($data,404);
        }
       // Si el estudiante existe, ejecuta el método delete para eliminarlo
        $student->delete();
        $data = [
            'message' => 'Estudiante Eliminado Satisfactoriamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //Actualizar Estudiantes
    public function update(Request $request,$id)
    {
        //Buscamos el estudiante por ID
        $student = Student::find($id);

        //Verificamos si el estudiante no existe
        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);
        //Si el Validator falla colocamos error en la validadcion
        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        //Entonces si el validator lo hace bien pues modificamos los campos que vienen del formulario
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        //Guardamos lo que modificamos
        $student->save();

        $data = [
            'message' => 'Estudiante Actualizado',
            'student' => $student,
            'status' => 200
        ];
        // Retornamos la respuesta JSON con los datos actualizados
        return response()->json($data, 200);
    }
}
