<?php

namespace App\Http\Controllers\API;

use App\Models\Club;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les sports
        $sports = DB::table('sports')
            ->get()
            ->toArray();

        // On récupère tous les clubs
        // $clubs = DB::table('clubs')
        //     ->join('sports', 'clubs.sport_id', '=', 'sports.id')
        //     ->select('clubs.*', 'sports.name')
        //     ->get()
        //     ->toArray();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
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
            'nameSport' => 'required|max:100',
        ]);

        // On crée un nouveau joueur
        $sport = Sport::create([
            'nameSport' => $request->nameSport,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $sport,
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function show(Sport $sport)
    {
        // On retourne les informations du Sport en JSON
        return response()->json($sport);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sport $sport)
    {
        $this->validate($request, [
            'nameSport' => 'required|max:100',
        ]);
        // On crée un nouveau sport
        $sport->update([
            'nameSport' => $request->nameSport,
        ]);
        // On retourne les informations du nouveau sport en JSON
        return response()->json($sport, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sport $sport)
    {
        // On supprime le sport
        $sport->delete();
        // On retourne la réponse JSON
        return response()->json();
    }
}
