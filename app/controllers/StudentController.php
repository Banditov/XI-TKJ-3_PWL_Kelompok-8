<?php
namespace App\Controllers;
class StudentController
{
    public function index()
        {
            echo "<h1>Daftar Siswa</h1>";
            echo "<p>Menampilkan daftar siswa</p>";
        }

    public function create()
        {
            echo "<h1>Tambah Siswa</h1>";
            echo "<p>Menampilkan form tambah siswa</p>";
        }
}