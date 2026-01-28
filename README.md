# 📘 BENihonGo - Final API Documentation

Dokumentasi ini menjelaskan endpoints dan cara penggunaan API untuk aplikasi BENihonGo.

## 💁‍♀️ Allowed HTTP Request

| Method | Deskripsi |
| :--- | :--- |
| `GET` | Mengambil data dari server. |
| `POST` | Membuat data baru / Mengirim form. |
| `PUT` | Mengupdate data (Khusus format JSON). |
| `POST` + `_method: PUT` | Mengupdate data yang berisi **FILE** (Gambar/Audio). |
| `DELETE` | Menghapus data. |

## 📝 Server Responses

| Code | Status | Keterangan |
| :--- | :--- | :--- |
| **200** | OK | Request sukses. |
| **201** | Created | Data berhasil dibuat. |
| **401** | Unauthorized | Token salah atau user belum login. |
| **404** | Not Found | Data atau ID tidak ditemukan. |
| **422** | Validation Error | Input salah (misal: email tidak valid, file terlalu besar). |

## 🔐 Authentication Headers

> **PENTING:** Semua route yang ditandai dengan gembok (🔒) **WAJIB** menyertakan header di bawah ini. Jika tidak, server akan mengembalikan error `401 Unauthorized`.

Pastikan request header mengandung:


Accept: application/json
Authorization: Bearer <your_access_token>

## 📚 Database Attributes (Schema Reference)

Referensi nama kolom di database (berguna untuk debugging frontend).

### 👤 Users & Gamification
- **users**: `id`, `name`, `email`, `password`, `avatar_path`
- **user_gamifications**: `level` (Lv), `current_exp` (XP saat ini), `gold` (Uang), `daily_exp_target` (Target harian)
- **user_settings**: `is_onboarding_completed`, `focus_duration` (Durasi Pomodoro favorit user)

### 🗺️ Learning Content
- **chapters**: `title` (Nama Bab), `chapter_number`
- **stages**: `chapter_id`, `monster_id` (Lawan), `name`, `image_path` (Background), `is_boss_level`
- **flashcards**: `kanji`, `romaji`, `meaning`, `audio_path`
- **quizzes**: `question`, `options` (Array Jawaban), `correct_answer`

# 👹 Game & Items
- **monsters**: `name`, `base_hp`, `asset_path` (Gambar Monster)
- **items**: `type` (avatar/frame), `price`, `asset_path`
- **pomodoro_logs**: `total_minutes`, `status` (completed/interrupted)

---


## 🚀 1. Authentication (Public)

Endpoint ini bersifat publik (tidak membutuhkan token Bearer).

### Register
- **URL:** `http://localhost:8000/api/register`
- **Method:** `POST`
- **Body:**
```json
{
    "name": "User Baru",
    "email": "user@test.com",
    "password": "password123",
    "password_confirmation": "password123"
}
``` 

### Login
- **URL:** `http://localhost:8000/api/login`
- **Method:** `POST`
- **Body:**
```json
{
    "email": "user@test.com",
    "password": "password123"
}
```  
### Logout 🔒
- **URL:** `http://localhost:8000/api/logout`
- **Method:** `POST`
- **Header:** Wajib menyertakan `Authorization: Bearer <token>`

---
## 👤 2. User & Dashboard (User App)

### Get User Profile (Me) 🔒
- **URL:** `http://localhost:8000/api/user`
- **Method:** `GET`
- **Response Example:**
```json
{
    "data": {
        "name": "Radhika",
        "avatar": "storage/assets/avatars/straw_hat.png",
        "gamification": { "level": 5, "gold": 1000 },
        "settings": { "focus_duration": 25 }
    }
}
```
> **💡 Note:** Field `settings.focus_duration` bisa dipakai Frontend untuk mengatur default timer di halaman Pomodoro (misal: otomatis pilih tombol 25 menit).

### Submit Onboarding 🔒
- **URL:** `http://localhost:8000/api/onboarding`
- **Method:** `POST`
- **Body:**
```json
{
    "daily_target_exp": 200, // Target Harian
    "focus_duration": 25     // Preferensi Timer (25/50 menit)
}
```
> **💡 Note:** Dipanggil sekali saja saat user baru selesai memilih target belajar.

### Get Leaderboard 🔒
- **URL:** `http://localhost:8000/api/leaderboard`
- **Method:** `GET`

---
## ⚔️ 3. Gameplay Logic

### Start Game (Load Stage) 🔒
- **URL:** `http://localhost:8000/api/game/start/{stage_id}`
- **Method:** `GET`

> **💡 Note:** Endpoint ini akan mengembalikan data Soal (Quizzes) dan Monster. Frontend simpan data ini di State lokal untuk menjalankan game.

### Finish Game (Submit Score) 🔒
- **URL:** `http://localhost:8000/api/game/finish`
- **Method:** `POST`

**Body:**
```json
{
    "stage_id": 1,
    "score": 100,      // Nilai akhir (0-100)
    "is_completed": true // Menang (true) atau Kalah (false)
}
```
**Response Example:**
```json
{
    "data": {
        "xp_gained": 50,
        "gold_gained": 20,
        "is_level_up": true // Cek ini untuk memunculkan animasi "Level Up!"
    }
}
```
---
## 🍅 4. Pomodoro Timer

Backend bertindak sebagai Stopwatch Server-Side.

### Start Timer 🔒
- **URL:** `http://localhost:8000/api/pomodoro/start`
- **Method:** `POST`

> **💡 Note:** Panggil ini saat user menekan tombol START. Backend mencatat waktu mulai.

### Stop Timer 🔒
- **URL:** `http://localhost:8000/api/pomodoro/stop`
- **Method:** `POST`
- **Body:**
```json
{ "status": "completed" }
```
> **💡 Note:** Panggil ini saat waktu habis atau user menekan **GIVE UP**.
> - Kirim `completed` jika waktu habis.
> - Kirim `interrupted` jika user stop manual di tengah jalan.
> - Backend akan otomatis menghitung durasi dan memberikan XP.

---
## 🛒 5. Shop & Inventory

### Get Shop Items 🔒
- **URL:** `http://localhost:8000/api/shop`
- **Method:** `GET`

> **💡 Note:** Cek field `owned` (true/false) di setiap item untuk menonaktifkan tombol **Beli** jika user sudah punya barangnya.

### Buy Item 🔒
- **URL:** `http://localhost:8000/api/shop/buy`
- **Method:** `POST`
- **Body:**
```json
{ "item_id": 1 }
```

### Equip Item 🔒
- **URL:** `http://localhost:8000/api/shop/equip`
- **Method:** `POST`
- **Body:**
```json
{ "item_id": 1 }
```
---
## 📖 6. Learning Content (Read Only)

### Get All Stages 🔒
- **URL:** `http://localhost:8000/api/stages`
- **Method:** `GET`

### Get Flashcards 🔒
- **URL:** `http://localhost:8000/api/flashcards?stage_id={id}`
- **Method:** `GET`

> **💡 Note:** Wajib pakai query param `?stage_id=...` agar hanya memunculkan materi di stage tersebut.

---
## 🛠 7. ADMIN CMS (Khusus Admin Dashboard) 🔒

> **⚠️ PERHATIAN KHUSUS UNTUK FRONTEND:**
> Endpoint Admin yang melibatkan Upload File (Gambar/Audio) memiliki aturan khusus.

### A. Chapters (JSON Biasa)
- **List:** `GET /api/admin/chapters`
- **Create:** `POST /api/admin/chapters`
    - **Body:**
    ```json
    { "title": "Bab 1", "chapter_number": 1 }
    ```
- **Update:** `PUT /api/admin/chapters/{id}`
- **Delete:** `DELETE /api/admin/chapters/{id}`

### B. Monsters 

#### 1. Create Monster
- **URL:** `/api/admin/monsters`
- **Method:** `POST`
- **Header:** `Content-Type: multipart/form-data`

**Body (Form-Data):**
```text
name: "Slime Hijau"
base_hp: 100
attack_interval_ms: 3000
damage_per_hit: 10
exp_reward: 50
gold_reward: 20
image: (File Gambar .png/.jpg)
```
**Response:**
```json
{
    "success": true,
    "message": "Monster berhasil ditambahkan!",
    "data": {
        "id": 1,
        "name": "Slime Hijau",
        "base_hp": 100,
        "asset_path": "storage/assets/monsters/slime.png",
        "created_at": "2026-01-26T10:00:00.000000Z"
    }
}
```

#### 2. Update Monster
> **⚠️ PENTING:** Gunakan `_method: "PUT"` karena HTML Form tidak bisa kirim file via method PUT langsung.

- **URL:** `/api/admin/monsters/{id}`
- **Method:** `POST`
- **Header:** `Content-Type: multipart/form-data`

**Body (Form-Data):**
```text
_method: "PUT"  
name: "Slime Merah"
base_hp: 150
image: (File Gambar Baru - Optional)
```
**Response:**
```json
{
    "success": true,
    "message": "Data Monster berhasil diupdate!",
    "data": {
        "id": 1,
        "name": "Slime Merah",
        "base_hp": 150,
        "asset_path": "storage/assets/monsters/slime_new.png"
    }
}
```

### C. Stages (Upload Gambar) 📸

#### 1. Create Stage
- **URL:** `/api/admin/stages`
- **Method:** `POST`
- **Header:** `Content-Type: multipart/form-data`

**Body (Form-Data):**
```text
chapter_id: 1
monster_id: 1
name: "Hutan Bambu"
description: "Latihan dasar huruf Hiragana"
stage_number: 1
level_req: 1
is_boss_level: 0               // 0 = False, 1 = True
image: (File Gambar .png/.jpg)
```
**Response Example:**
```json
{
    "success": true,
    "message": "Stage berhasil dibuat!",
    "data": {
        "id": 1,
        "name": "Hutan Bambu",
        "stage_number": 1,
        "image_path": "storage/assets/stages/forest.png",
        "monster_id": 1
    }
}
```

#### 2. Update Stage
> **⚠️ PENTING:** Gunakan `_method: "PUT"` karena ada upload file.

- **URL:** `/api/admin/stages/{id}`
- **Method:** `POST`
- **Header:** `Content-Type: multipart/form-data`

**Body (Form-Data):**
```text
_method: "PUT"  
name: "Hutan Bambu Gelap"
level_req: 5
image: (File Gambar Baru - Optional)
```
**Response Example:**
```json
{
    "success": true,
    "message": "Stage berhasil diupdate!",
    "data": {
        "id": 1,
        "name": "Hutan Bambu Gelap",
        "level_req": 5,
        "image_path": "storage/assets/stages/dark_forest.png"
    }
}
```
### D. Flashcards (Upload Audio) 🎵

#### 1. Create Flashcard
- **URL:** `/api/admin/flashcards`
- **Method:** `POST`
- **Header:** `Content-Type: multipart/form-data`

**Body (Form-Data):**
```text
stage_id: 1
kanji: "山"
romaji: "Yama"
meaning: "Gunung"
audio: (File Audio .mp3/.wav - Optional)
```
**Response Example:**
```json
{
    "success": true,
    "message": "Flashcard berhasil ditambahkan!",
    "data": {
        "id": 10,
        "kanji": "山",
        "romaji": "Yama",
        "audio_path": "storage/assets/audio/yama.mp3"
    }
}
```
#### 2. Update Flashcard
> **⚠️ PENTING:** Gunakan `_method: "PUT"` jika ingin update audio.

- **URL:** `/api/admin/flashcards/{id}`
- **Method:** `POST`
- **Header:** `Content-Type: multipart/form-data`

**Body (Form-Data):**
```text
_method: "PUT" 
meaning: "Gunung Berapi"
audio: (File Audio Baru - Optional)
```
**Response Example:**
```json
{
    "success": true,
    "message": "Flashcard berhasil diupdate!",
    "data": {
        "id": 10,
        "meaning": "Gunung Berapi",
        "audio_path": "storage/assets/audio/yama_new.mp3"
    }
}
```

### E. Quizzes (JSON Biasa)
> **💡 Note:** Karena tidak ada upload file, bagian ini **TIDAK PERLU** FormData atau `_method: PUT`. Cukup JSON biasa.

#### 1. Create Quiz
- **URL:** `/api/admin/quizzes`
- **Method:** `POST`
- **Header:** `Content-Type: application/json`

**Body (JSON):**
```json
{
    "stage_id": 1,
    "question": "Apa arti dari kanji 'Yama'?",
    "options": ["Sungai", "Gunung", "Laut", "Langit"],
    "correct_answer": "Gunung"
}
```
**Response Example:**
```json
{
    "success": true,
    "message": "Soal Quiz berhasil dibuat!",
    "data": {
        "id": 50,
        "question": "Apa arti dari kanji 'Yama'?",
        "options": ["Sungai", "Gunung", "Laut", "Langit"],
        "correct_answer": "Gunung"
    }
}
```

#### 2. Update Quiz
- **URL:** `/api/admin/quizzes/{id}`
- **Method:** `PUT`
- **Header:** `Content-Type: application/json`

**Body (JSON):**
```json
{
    "question": "Apa bahasa Jepang dari 'Gunung'?",
    "options": ["Kawa", "Yama", "Umi", "Sora"],
    "correct_answer": "Yama"
}
```

**Response Example:**
```json
{
    "success": true,
    "message": "Soal Quiz berhasil diupdate!",
    "data": {
        "id": 50,
        "question": "Apa bahasa Jepang dari 'Gunung'?",
        "correct_answer": "Yama"
    }
}
```

