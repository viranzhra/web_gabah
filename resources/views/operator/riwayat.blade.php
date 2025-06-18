@extends('layout.nav')

@section('content')
  <style>
    /* body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 20px;
    } */
    .header-judul {
      background-color: #003087;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header-judul select, .header-judul input {
      padding: 5px;
      margin-left: 10px;
      border: none;
      border-radius: 3px;
      background-color: #0055a4;
      color: white;
    }
    .header-judul input[type="text"] {
      width: 150px;
    }
    .header-judul button {
      background-color: #ff0000;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      cursor: pointer;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .col-lg-4 {
      flex: 0 0 50%; /* Increased width to 50% for wider card */
      max-width: 50%;
    }
    .card {
      background-color: white;
      border-radius: 5px;
      width: 100%;
    }
    .card-body {
      padding: 30px;
    }
    .card-title {
      font-weight: bold;
      margin-bottom: 20px;
      margin-top: 0px;
      font-size: 20px;
    }
    .timeline-container {
      list-style: none;
      padding: 0;
      position: relative;
      margin-bottom: -20px;
    }
    .timeline-container::before {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      left: 100px; /* Adjusted to move timeline further right */
      width: 2px;
      background-color: #003087;
    }
    .timeline-entry {
      display: flex;
      align-items: flex-start;
      position: relative;
      /* overflow: hidden; */
      margin-bottom: 20px;
    }
    .timeline-date {
      min-width: 120px;
      text-align: left;
      margin-right: -100px;
      color: #003087;
      font-weight: bold;
      /* position: absolute; */
      left: -20px; /* Moved further left to avoid overlap with timeline */
    }
    .timeline-marker {
      width: 12px;
      height: 12px;
      background-color: #003087;
      border: 2px solid #fff;
      border-radius: 50%;
      position: absolute;
      left: 93px; /* Adjusted to align with new timeline position */
      top: 4px;
      z-index: 1;
    }
    .event-card {
      margin-left: 100px; /* Adjusted to place card to the right of timeline with more space */
      padding: 15px;
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      width: 100%; /* Ensure card takes full available width */
    }
    .event-card.ongoing {
      background-color: #fff3cd;
    }
    .event-card.completed {
      background-color: #d4edda;
    }
    .event-details {
      color: #000;
      font-size: 16px;
    }
    .status {
      padding: 2px 10px;
      border-radius: 3px;
      color: white;
      margin-left: 10px;
    }
    .status.Ongoing {
      background-color: #ff9800;
    }
    .status.Selesai {
      background-color: #28a745;
    }
    .details {
      color: #007bff;
      text-decoration: underline;
      cursor: pointer;
      margin-left: 10px;
    }
  </style>

  <div class="header-judul">
    <div>
      <select>
        <option>Jenis Gabah</option>
      </select>
      <input type="date" placeholder="Tanggal Awal">
      <input type="date" placeholder="Tanggal Akhir">
      <button>🔍</button>
    </div>
    <button>Download PDF</button>
  </div>

  <div class="row">
    <div class="col-lg-4 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="mb-4">
            <h5 class="card-title fw-semibold">Riwayat Proses</h5>
          </div>
          <ul class="timeline-container mb-0 position-relative mb-n5">
            <li class="timeline-entry d-flex position-relative overflow-hidden">
              <div class="timeline-date">10 Mei 2025</div>
              <span class="timeline-marker"></span>
              <div class="event-card ongoing">
                <div class="event-details">
                  <div>Ciherang</div>
                  <div><span class="status Ongoing">Ongoing</span> 15:00 - 21:00</div>
                  <div>Waktu Estimasi: 6 jam 0 menit</div>
                  <div>Durasi Nyata: -</div>
                  <span class="details">Detail</span>
                </div>
              </div>
            </li>
            <li class="timeline-entry d-flex position-relative overflow-hidden">
              <div class="timeline-date"></div>
              <span class="timeline-marker" style="visibility: hidden;"></span>
              <div class="event-card ongoing">
                <div class="event-details">
                  <div>Inpari</div>
                  <div><span class="status Ongoing">Ongoing</span> 15:00 - 21:00</div>
                  <div>Waktu Estimasi: 6 jam 0 menit</div>
                  <div>Durasi Nyata: -</div>
                  <span class="details">Detail</span>
                </div>
              </div>
            </li>
            <li class="timeline-entry d-flex position-relative overflow-hidden">
              <div class="timeline-date"></div>
              <span class="timeline-marker" style="visibility: hidden;"></span>
              <div class="event-card ongoing">
                <div class="event-details">
                  <div>Inpari</div>
                  <div><span class="status Ongoing">Ongoing</span> 15:00 - 21:00</div>
                  <div>Waktu Estimasi: 6 jam 0 menit</div>
                  <div>Durasi Nyata: -</div>
                  <span class="details">Detail</span>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection