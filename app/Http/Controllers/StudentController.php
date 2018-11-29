<?php

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     schemes={"http", "https"},
 *     host="http://localhost:8080",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Laravel API - Curso TreinaWeb",
 *         description="Projeto do Curso Laravel APIs Restfull TreinaWeb",
 *         @SWG\Contact(
 *             email="railtonleal98@gmail.com"
 *         ),
 *     )
 * )
 */

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;

class StudentController extends Controller
{
    /**
     * @SWG\Get(
     *      path="/students",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
     *      summary="Get list of students",
     *      description="Returns list of students",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of students
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('includes') === 'classroom') {
            $students = Student::with('classroom')->paginate(1);
        } else {
            $students = Student::paginate();
        }

        return (new StudentCollection($students))
                    ->response()
                    ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        return Student::create($request->all());

    }

    /**
     * @SWG\Get(
     *      path="/students/{id}",
     *      operationId="getProjectById",
     *      tags={"Projects"},
     *      summary="Get student information",
     *      description="Returns student data",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @SWG\Response(response=400, description="Bad request"),
     *      @SWG\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:students", "read:students"}
     *         }
     *     },
     * )
     *
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $student->load('classroom');

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return [];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return [];
    }
}
