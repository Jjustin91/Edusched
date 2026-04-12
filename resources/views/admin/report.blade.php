<!DOCTYPE html>
<html>
<head>
    <title>EduSched User Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #1e3a8a; text-align: center; }
        table { w-full; border-collapse: collapse; margin-top: 20px; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; color: #1e3a8a; }
        .amber-text { color: #d97706; font-weight: bold; }
    </style>
</head>
<body>
    <h1>EduSched - Official User Report</h1>
    <p>Generated on: {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>

    <h3>Registered Faculty</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->name }}</td>
                <td class="amber-text">{{ $teacher->department ?? 'N/A' }}</td>
                <td>{{ $teacher->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Registered Students</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Account Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>