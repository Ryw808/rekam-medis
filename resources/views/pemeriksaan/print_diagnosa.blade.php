<html>
<head>
    <title>Laporan Kunjungan Pasien</title>
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}">
    <style type="text/css">
      @media print {
        @page { margin: 0px; 
                size: A4 landscape;
              }
        body { 
          margin:1.5cm;
        }
      }

      body{
        margin:1cm;
        font-size: 8pt;
      }
      #ket{
        margin-top: 10px;
        margin-bottom: 10px;
      }
    </style>
</head>
<body>
<div class="panel panel default">
   <div class="panel-heading">
        <h3 align="center">Laporan Kunjungan Pasien</h3>
  </div>
  <div class="panel-body">

    <div class="row" id="ket">
      <div class="col-md-12">
          <table>
            <tbody>
              <tr>
                <td width="70px">Nama Pasien</td>
                <td width="10px">:</td>
                <td>{{ $first->nama }}</td>
              </tr>
              <tr>
                <td>Tanggal Daftar</td>
                <td>:</td>
                <td>{{ $first->tgl_daftar }} </td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>

    <table class="table">
      <thead>
         <tr>
           <th>No</th>
           <th>Tanggal</th>
           <th>Nama Pasien</th>
           <th>Diagnosa 1</th>
           <th>Diagnosa 2</th>
            <th>Anamnesa</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        @foreach ($diagnosa_print as $data)
        <tr>
          <td>{{ $no++ }}</td>
          <td>{{ date('d/m/y', strtotime($data->tgl_periksa)) }}</td>
          <td>{{ $data->nama }}</td> 
          <td>{{ $data->diagnosa_1 }}</td>
          <td>{{ $data->diagnosa_2 }}</td> 
          <td>{{$data->anamnesa}}<td>
        </tr> 
        @endforeach
        </tbody>
    </table>
    <div class="col-md-12" id="rincian" style="margin-top: 50px;">
      <div class="row">
        Keterangan : 
      </div>
      <div class="row">
        - Total Kunjungan : {{ count($diagnosa_print) }}
      </div>

    </div>
  </div>
</div>

<script>
  window.print();
    window.onafterprint = function() {
        history.go(-1);
    }; 
</script>

</body>
</html>