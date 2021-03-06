<?php

namespace App\Http\Controllers\API;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Club;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les joueurs
        $players = DB::table('players')
            ->get()
            ->toArray();

        // On récupère tous les clubs
        $clubs = DB::table('clubs')
            ->join('players', 'clubs.player_id', '=', 'players.id')
            ->select('clubs.*', 'players.name')
            ->get()
            ->toArray();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $players,
            'data' => $clubs,
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
        $clubs = Club::all();

        $request->validate([
            'firstName' => 'required|max:100',
            'lastName' => 'required|max:100',
            'height' => 'required|max:100',
            'position' => 'required|max:100',
            'club_id' => 'required',
        ]);

        $filename = "";
        if ($request->hasFile('photoPlayer')) {
            // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
            $filenameWithExt = $request->file('photoPlayer')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // On récupère l'extension du fichier, résultat $extension : ".jpg"
            $extension = $request->file('photoPlayer')->getClientOriginalExtension();
            // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore :"jeanmiche_20220422.jpg"
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
            $path = $request->file('photoPlayer')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }

        // On crée un nouveau joueur
        $player = Player::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'height' => $request->height,
            'position' => $request->position,
            'club_id' => $request->club_id,
            'photoPlayer' =>$filename,
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $player,
            'data' => $clubs,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($player);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        $this->validate($request, [
            'firstName' => 'required|max:100',
            'lastName' => 'required|max:100',
            'height' => 'required|max:100',
            'position' => 'required|max:100',
        ]);
        // On crée un nouvel utilisateur
        $player->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'height' => $request->height,
            'position' => $request->position,
        ]);
        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json($player, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        // On supprime l'utilisateur
        $player->delete();
        // On retourne la réponse JSON
        return response()->json();
    }
}
