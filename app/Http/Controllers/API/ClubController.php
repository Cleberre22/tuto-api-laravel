<?php

namespace App\Http\Controllers\API;

use App\Models\Club;
use App\Models\Sport;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les clubs
        $clubs = DB::table('clubs')
            ->get()
            ->toArray();

        // On récupère tous les sports
        $sports = DB::table('sports')
            ->join('clubs', 'sports.club_id', '=', 'clubs.id')
            ->select('sports.*', 'clubs.name')
            ->get()
            ->toArray();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $clubs,
            'data' => $sports,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:100',
            'sport_id' => 'required',
        ]);

        // On crée un nouveau club
        $club = Club::create([
            'name' => $request->name,
            'sport_id' => $request->sport_id,
        ]);

        //Comment remplir une table pivot de façon bien dégueulasse

        //Je récupère mes catégories dans le formulaire
        $sport = $request->sports;
        //Je les mets dans un tableau
        $sportsid = explode(",", $sport);
        //Et le boucle pour les rentrer dans la base de données
        for ($i = 0; $i < count($sportsid); $i++) {
            $sport = Sport::find($sportsid[$i]);
            $club->sport()->attach($sport);
        }

        // On retourne les informations du nouveau club en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $club,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        // On retourne les informations du club en JSON
        return response()->json($club);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        // On modifie le club
        $club->update([
            'name' => $request->name,
        ]);
        // On retourne les informations modifié du club en JSON
        return response()->json($club, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        // On supprime le club
        $club->delete();
        // On retourne la réponse JSON
        return response()->json();
    }
}
