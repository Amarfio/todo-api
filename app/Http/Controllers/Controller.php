<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
     * @OA\OpenApi(
     *     @OA\Info(
     *         version="1.0",
     *         title="Todo List Api",
     *         description="The ToDo API is a RESTful web service that allows users to manage their tasks and create to-do lists. It provides a set of endpoints to perform CRUD (Create, Read, Update, Delete) operations on tasks and supports various features for organizing and prioritizing tasks.The ToDo API with Swagger UI offers a user-friendly interface to developers, allowing them to understand the API endpoints, their parameters, and response structures. It simplifies the integration process and facilitates the development of client applications that interact with the ToDo API.",
     *         version="1.0.2",
     *         contact = {
     *            "email": "joshuaamarfio1@gmail.com"
     *         }
     *     )
     * )
     */
class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
