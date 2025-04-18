<?php
namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventGuestController extends Controller
{
    public function home(Request $request)
    {
        $query = Event::with('tikets')
            ->where('status', 'approved')
            ->whereDate('tgl_mulai', '>=', Carbon::today());

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events      = $query->orderBy('tgl_mulai', 'asc')->take(3)->get();
        $eventGratis = Event::with('tikets')
            ->whereHas('tikets', function ($query) {
                $query->where('harga', 0);
            })
            ->whereDate('tgl_mulai', '>=', now())
            ->orderBy('tgl_mulai', 'asc')
            ->first();

        $events = $events->map(function ($event) {
            $event->harga = $event->tikets->min('harga'); // Perbaikan
            return $event;
        });

        $categories = Kategori::all();

        return view('guest.home', compact('events', 'categories', 'eventGratis'));
    }

    public function show($slug)
    {
        $event = Event::with(['kategoris', 'tikets'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->first();

        if (! $event) {
            abort(404, 'Event tidak ditemukan');
        }

        $event->harga = $event->tikets->min('harga');

        $categories = Kategori::all();

        $relatedEvents = Event::whereHas('kategoris', function ($query) use ($event) {
            $query->whereIn('kategori_id', $event->kategoris->pluck('id')->toArray());
        })
            ->where('id', '!=', $event->id)
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        return view('guest.detail', compact('event', 'relatedEvents', 'categories'));
    }

    public function index(Request $request)
    {
        $query = Event::with(['kategoris', 'tikets'])
            ->where('status', 'approved')
            ->latest();

        if ($request->filled('kategori')) {
            $query->whereHas('kategoris', function ($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            });
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(6);

        $events->getCollection()->transform(function ($event) {
            $event->harga = $event->tikets->min('harga');
            return $event;
        });

        $categories = Kategori::all();

        return view('guest.event', compact('events', 'categories'));
    }

    public function about()
    {
        return view('guest.about'); // Ganti dengan view yang sesuai
    }
    public function kontak()
    {
        return view('guest.kontak'); // Ganti dengan view yang sesuai
    }

}
