<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; margin: 0; padding: 32px; font-size: 12px; }
        h1 { font-size: 24px; margin-bottom: 6px; }
        h2 { font-size: 16px; margin-top: 28px; margin-bottom: 8px; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px; }
        .meta { color: #6b7280; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        th { background: #f3f4f6; font-weight: 600; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .stat-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; }
        .stat-title { font-size: 10px; text-transform: uppercase; color: #6b7280; letter-spacing: .05em; margin-bottom: 4px; }
        .stat-value { font-size: 16px; font-weight: 700; }
        .small { font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <h1>Raport systemowy</h1>
    @if(isset($summary))
        <p class="meta">Wygenerowano: {{ $summary['generated_at']->format('d.m.Y H:i') }}</p>
    @endif

    @if(isset($summary) && in_array('summary', $selectedSections ?? []))
        <div class="grid">
            <div class="stat-card">
                <div class="stat-title">Użytkownicy</div>
                <div class="stat-value">{{ $summary['users'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Uczniowie</div>
                <div class="stat-value">{{ $summary['students'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Nauczyciele</div>
                <div class="stat-value">{{ $summary['teachers'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Klasy</div>
                <div class="stat-value">{{ $summary['classes'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Przedmioty</div>
                <div class="stat-value">{{ $summary['subjects'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Wprowadzone oceny</div>
                <div class="stat-value">{{ $summary['grades'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Średnia ocen</div>
                <div class="stat-value">{{ number_format($summary['average_grade'], 2) }}</div>
            </div>
        </div>
    @endif

    @if(isset($classes) && in_array('classes', $selectedSections ?? []))
        <h2>Struktura klas</h2>
        <table>
            <thead>
                <tr>
                    <th>Klasa</th>
                    <th>Rok</th>
                    <th>Liczba uczniów</th>
                    <th>Liczba przedmiotów</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->year }}</td>
                        <td>{{ $class->students_count }}</td>
                        <td>{{ $class->subjects_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($topStudents) && in_array('top_students', $selectedSections ?? []))
        <h2>Najaktywniejsi uczniowie</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Uczeń</th>
                    <th>Liczba ocen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topStudents as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->grades_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="small">Brak danych</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if(isset($topTeachers) && in_array('top_teachers', $selectedSections ?? []))
        <h2>Najaktywniejsi nauczyciele</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nauczyciel</th>
                    <th>Wprowadzone oceny</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topTeachers as $index => $teacher)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->grades_as_teacher_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="small">Brak danych</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>
