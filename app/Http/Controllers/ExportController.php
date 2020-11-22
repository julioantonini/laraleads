<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Lead;

class ExportController extends Controller
{

  public function index()
  {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="leads.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header ('Cache-Control: cache, must-revalidate');
    header ('Pragma: public');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setWidth(20);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    $sheet->getColumnDimension('J')->setAutoSize(true);
    $sheet->getColumnDimension('K')->setAutoSize(true);

    if(auth()->user()->privilege_id === 3){
      $sheet->setCellValue('A1', 'Nome');
      $sheet->setCellValue('B1', 'E-mail');
      $sheet->setCellValue('C1', 'Telefone');
      $sheet->setCellValue('D1', 'CPF');
      $sheet->setCellValue('E1', 'Data de nascimento');
      $sheet->setCellValue('F1', 'Renda');
      $sheet->setCellValue('G1', 'Mensagem');
      $sheet->setCellValue('H1', 'Estágio');
      $sheet->setCellValue('I1', 'Corretor');
      $sheet->setCellValue('J1', 'Equipe');
      $sheet->setCellValue('K1', 'Data de cadastro');

      $linha = 2;

      $leads =  Lead::with(['funnel','team','user'])->orderByDesc('created_at')->get();
      foreach($leads as $l){
        $sheet->setCellValue("A$linha", $l->name);
        $sheet->setCellValue("B$linha", $l->email);
        $sheet->setCellValue("C$linha", $l->phone);
        $sheet->setCellValue("D$linha", $l->cpf);
        $sheet->setCellValue("E$linha", $l->birthdate);
        $sheet->setCellValue("F$linha", $l->income);
        $sheet->setCellValue("G$linha", $l->comments);
        $sheet->setCellValue("H$linha", $l->funnel->name);
        $sheet->setCellValue("I$linha", $l->user->name);
        $sheet->setCellValue("J$linha", $l->team ? $l->team->name : '');
        $sheet->setCellValue("K$linha", date( 'd/m/Y H:i' , strtotime($l->created_at)));

        $linha++;
      }
    }else if(auth()->user()->privilege_id === 2){
      $sheet->setCellValue('A1', 'Nome');
      $sheet->setCellValue('B1', 'E-mail');
      $sheet->setCellValue('C1', 'Telefone');
      $sheet->setCellValue('D1', 'CPF');
      $sheet->setCellValue('E1', 'Data de nascimento');
      $sheet->setCellValue('F1', 'Renda');
      $sheet->setCellValue('G1', 'Mensagem');
      $sheet->setCellValue('H1', 'Estágio');
      $sheet->setCellValue('I1', 'Corretor');
      $sheet->setCellValue('j1', 'Data de cadastro');

      $linha = 2;

      $leads =  Lead::where('team_id', auth()->user()->team_id)->with(['funnel','user'])->orderByDesc('created_at')->get();
      foreach($leads as $l){
        $sheet->setCellValue("A$linha", $l->name);
        $sheet->setCellValue("B$linha", $l->email);
        $sheet->setCellValue("C$linha", $l->phone);
        $sheet->setCellValue("D$linha", $l->cpf);
        $sheet->setCellValue("E$linha", $l->birthdate);
        $sheet->setCellValue("F$linha", $l->income);
        $sheet->setCellValue("G$linha", $l->comments);
        $sheet->setCellValue("H$linha", $l->funnel->name);
        $sheet->setCellValue("I$linha", $l->user->name);
        $sheet->setCellValue("J$linha", date( 'd/m/Y H:i' , strtotime($l->created_at)));

        $linha++;
      }
    }else if(auth()->user()->privilege_id === 1){
      $sheet->setCellValue('A1', 'Nome');
      $sheet->setCellValue('B1', 'E-mail');
      $sheet->setCellValue('C1', 'Telefone');
      $sheet->setCellValue('D1', 'CPF');
      $sheet->setCellValue('E1', 'Data de nascimento');
      $sheet->setCellValue('F1', 'Renda');
      $sheet->setCellValue('G1', 'Mensagem');
      $sheet->setCellValue('H1', 'Estágio');
      $sheet->setCellValue('I1', 'Data de cadastro');

      $linha = 2;

      $leads =  Lead::where('team_id', auth()->user()->team_id)->with(['funnel','user'])->orderByDesc('created_at')->get();
      foreach($leads as $l){
        $sheet->setCellValue("A$linha", $l->name);
        $sheet->setCellValue("B$linha", $l->email);
        $sheet->setCellValue("C$linha", $l->phone);
        $sheet->setCellValue("D$linha", $l->cpf);
        $sheet->setCellValue("E$linha", $l->birthdate);
        $sheet->setCellValue("F$linha", $l->income);
        $sheet->setCellValue("G$linha", $l->comments);
        $sheet->setCellValue("H$linha", $l->funnel->name);
        $sheet->setCellValue("I$linha", date( 'd/m/Y H:i' , strtotime($l->created_at)));

        $linha++;
      }
    }

    $writer = new Xlsx($spreadsheet);
    return $writer->save('php://output');
  }


  public function store(Request $request)
  {
    $rules = [
      'user_id' => 'required',
    ];

    $names = [
      'user_id' => 'Corretor',
    ];

    $request->validate($rules, [], $names);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="leads.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header ('Cache-Control: cache, must-revalidate');
    header ('Pragma: public');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setWidth(20);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    $sheet->getColumnDimension('J')->setAutoSize(true);
    $sheet->getColumnDimension('K')->setAutoSize(true);

    if(auth()->user()->privilege_id === 3){
      $sheet->setCellValue('A1', 'Nome');
      $sheet->setCellValue('B1', 'E-mail');
      $sheet->setCellValue('C1', 'Telefone');
      $sheet->setCellValue('D1', 'CPF');
      $sheet->setCellValue('E1', 'Data de nascimento');
      $sheet->setCellValue('F1', 'Renda');
      $sheet->setCellValue('G1', 'Mensagem');
      $sheet->setCellValue('H1', 'Estágio');
      $sheet->setCellValue('I1', 'Corretor');
      $sheet->setCellValue('J1', 'Equipe');
      $sheet->setCellValue('K1', 'Data de cadastro');

      $linha = 2;

      $leads =  Lead::with(['funnel','team','user'])->where('user_id', $request->user_id)->orderByDesc('created_at')->get();
      foreach($leads as $l){
        $sheet->setCellValue("A$linha", $l->name);
        $sheet->setCellValue("B$linha", $l->email);
        $sheet->setCellValue("C$linha", $l->phone);
        $sheet->setCellValue("D$linha", $l->cpf);
        $sheet->setCellValue("E$linha", $l->birthdate);
        $sheet->setCellValue("F$linha", $l->income);
        $sheet->setCellValue("G$linha", $l->comments);
        $sheet->setCellValue("H$linha", $l->funnel->name);
        $sheet->setCellValue("I$linha", $l->user->name);
        $sheet->setCellValue("J$linha", $l->team ? $l->team->name : '');
        $sheet->setCellValue("K$linha", date( 'd/m/Y H:i' , strtotime($l->created_at)));

        $linha++;
      }
    }else if(auth()->user()->privilege_id === 2){
      $sheet->setCellValue('A1', 'Nome');
      $sheet->setCellValue('B1', 'E-mail');
      $sheet->setCellValue('C1', 'Telefone');
      $sheet->setCellValue('D1', 'CPF');
      $sheet->setCellValue('E1', 'Data de nascimento');
      $sheet->setCellValue('F1', 'Renda');
      $sheet->setCellValue('G1', 'Mensagem');
      $sheet->setCellValue('H1', 'Estágio');
      $sheet->setCellValue('I1', 'Corretor');
      $sheet->setCellValue('j1', 'Data de cadastro');

      $linha = 2;

      $leads =  Lead::where('team_id', auth()->user()->team_id)->where('user_id', $request->user_id)->with(['funnel','user'])->orderByDesc('created_at')->get();
      foreach($leads as $l){
        $sheet->setCellValue("A$linha", $l->name);
        $sheet->setCellValue("B$linha", $l->email);
        $sheet->setCellValue("C$linha", $l->phone);
        $sheet->setCellValue("D$linha", $l->cpf);
        $sheet->setCellValue("E$linha", $l->birthdate);
        $sheet->setCellValue("F$linha", $l->income);
        $sheet->setCellValue("G$linha", $l->comments);
        $sheet->setCellValue("H$linha", $l->funnel->name);
        $sheet->setCellValue("I$linha", $l->user->name);
        $sheet->setCellValue("J$linha", date( 'd/m/Y H:i' , strtotime($l->created_at)));

        $linha++;
      }
    }

    $writer = new Xlsx($spreadsheet);
    return $writer->save('php://output');
  }


}
