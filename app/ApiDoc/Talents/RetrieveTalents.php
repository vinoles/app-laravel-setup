<?php

namespace App\ApiDoc\Talents;

use App\ApiDoc\ApiDoc;
use OpenApi\Annotations as OA;

/**
 *
 * @OA\Get(
 *     path="/api/v1/talents",
 *     operationId="retrieveTalents",
 *     tags={"Talents"},
 *     summary="List talents",
 *     description="List talents endpoint",
 *     security={ {"sanctum": {} }},
 *     @OA\Parameter(
 *         name="accept",
 *         in="header",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="application/vnd.api+json"
 *         ),
 *         description="Media type to accept"
 *     ),
 *     @OA\Parameter(
 *         name="page[number]",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="integer",
 *             default=1
 *         ),
 *         description="Number page for pagination"
 *     ),
 *     @OA\Parameter(
 *         name="page[size]",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="integer",
 *             default=10
 *         ),
 *         description="Number of elements for page"
 *     ),
 *     @OA\Parameter(
 *         name="filter[hand_preference]",
 *         in="query",
 *         @OA\Schema(
 *         type="string",
 *         enum={"left", "right", "ambidextrous"},
 *         ),
 *         description="Filter for firstName attribute"
 *     ),
 *     @OA\Response(
 *       response="200",
 *       description="Retrieve Talents Successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\MediaType(
 *                 mediaType="application/vnd.api+json"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Unprocessable Entity",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\MediaType(
 *                 mediaType="application/vnd.api+json"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\MediaType(
 *                 mediaType="application/vnd.api+json"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=406,
 *         description="Not Acceptable",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\MediaType(
 *                 mediaType="application/vnd.api+json"
 *             )
 *         )
 *     )
 * )
 *
 */
class RetrieveTalents extends ApiDoc
{
}
