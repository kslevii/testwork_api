<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Notebook\StoreRequest;
use App\Http\Requests\Notebook\UpdateRequest;
use App\Models\Notebook;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


// Swagger annotation
/**
 *
 * @OA\Get (
 *     path="/api/v1/notebooks",
 *     summary="Просмотр страницы записей, выводится 10 постов, пагинацией",
 *     tags={"Notebook"},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="current_page", type="integer", example="1"),
 *             @OA\Property(property="data", type="array", @OA\Items(
 *                 @OA\Property(property="full_name", type="string", example="Иванов Иван Иванович"),
 *                 @OA\Property(property="phone_number", type="integer", example="89009998877"),
 *                 @OA\Property(property="email", type="string", example="ivanov@gmail.com"),
 *                 @OA\Property(property="company", type="string", example="google"),
 *                 @OA\Property(property="birth_of_day", type="date", example="2000.01.01"),
 *                 @OA\Property(property="src_image", type="string", example="imagur.com/image145141"),
 *             )),
 *         )
 *
 *     ),
 * )
 *
 * @OA\Post(
 *     path="/api/v1/notebooks",
 *     summary="Добавление новой записи",
 *     tags={"Notebook"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="full_name", type="string", example="Иванов Иван Иванович"),
 *                     @OA\Property(property="phone_number", type="integer", example="89009998877"),
 *                     @OA\Property(property="email", type="string", example="ivanov@gmail.com"),
 *                     @OA\Property(property="company", type="string", example="google"),
 *                     @OA\Property(property="birth_of_day", type="date", example="2000.01.01"),
 *                     @OA\Property(property="src_image", type="string", example="imagur.com/image145141"),
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Success",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="full_name", type="string", example="Иванов Иван Иванович"),
 *             @OA\Property(property="phone_number", type="integer", example="89009998877"),
 *             @OA\Property(property="email", type="string", example="ivanov@gmail.com"),
 *             @OA\Property(property="company", type="string", example="google"),
 *             @OA\Property(property="birth_of_day рождения", type="date", example="2000.01.01"),
 *             @OA\Property(property="src_image", type="string", example="imagur.com/image145141"),
 *         )
 *     ),
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/notebooks/{notebook}",
 *     summary="Просмотр одной записи",
 *     tags={"Notebook"},
 *
 *     @OA\Parameter(
 *         description="ID записи",
 *         in="path",
 *         name="notebook",
 *         required=true,
 *         example=1,
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(property="full_name", type="string", example="Иванов Иван Иванович"),
 *             @OA\Property(property="phone_number", type="integer", example="89009998877"),
 *             @OA\Property(property="email", type="string", example="ivanov@gmail.com"),
 *             @OA\Property(property="company", type="string", example="google"),
 *             @OA\Property(property="birth_of_day рождения", type="date", example="2000.01.01"),
 *             @OA\Property(property="src_image", type="string", example="imagur.com/image145141"),
 *         )
 *     )
 * ),
 *
 * @OA\Patch(
 *     path="api/v1/notebooks/{notebook}",
 *     summary="Update одной записи",
 *     tags={"Notebook"},
 *
 *     @OA\Parameter(
 *         description="ID записи",
 *         in="path",
 *         name="notebook",
 *         required=true,
 *         example=1,
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="full_name", type="string", example="Сидоров Иван Иванович"),
 *                     @OA\Property(property="phone_number", type="integer", example="89007778822"),
 *                     @OA\Property(property="email", type="string", example="sidorov@gmail.com"),
 *                     @OA\Property(property="company", type="string", example="Amazon"),
 *                     @OA\Property(property="birth_of_day", type="date", example="1998.05.10"),
 *                     @OA\Property(property="src_image", type="string", example="imagur.com/image6418641"),
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="full_name", type="string", example="Сидоров Иван Иванович"),
 *             @OA\Property(property="phone_number", type="integer", example="89007778822"),
 *             @OA\Property(property="email", type="string", example="sidorov@gmail.com"),
 *             @OA\Property(property="company", type="string", example="Amazon"),
 *             @OA\Property(property="birth_of_day", type="date", example="1998.05.10"),
 *             @OA\Property(property="src_image", type="string", example="imagur.com/image6418641"),
 *         )
 *     )
 * ),
 *
 * @OA\Delete(
 *      path="/api/v1/notebooks/{notebook}",
 *      summary="Удаление записи",
 *      tags={"Notebook"},
 *
 *      @OA\Parameter(
 *          description="ID записи",
 *          in="path",
 *          name="notebook",
 *          required=true,
 *          example=1,
 *      ),
 *
 *      @OA\Response(
 *          response=204,
 *          description="Success",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Success"),
 *          )
 *      )
 *  ),
 */

class NotebookController extends Controller
{
    public function index(): JsonResponse
    {
        $notebooks = Notebook::paginate(10);
        return response()->json($notebooks);
    }

    public function store(StoreRequest $request): Response|JsonResponse
    {
        try {
            $data = $request->validated();
            $notebook = Notebook::create($data);

            return response()->json($notebook, 201);
        } catch (QueryException $ex) {
            return response([
                'code_status' => '400',
                'error' => $ex->getMessage()
            ],400);
        }
    }

    public function show(Notebook $notebook): JsonResponse
    {
            $user = Notebook::findOrFail($notebook->id);
            return response()->json($user);
    }

    public function update(UpdateRequest $request, Notebook $notebook): JsonResponse
    {
            $data = $request->validated();
            $notebook->update($data);

            return response()->json($notebook, 200);
    }

    public function destroy(Notebook $notebook): JsonResponse
    {
        $notebook->delete();
        return response()->json(['message' => 'Success'],204);
    }
}
