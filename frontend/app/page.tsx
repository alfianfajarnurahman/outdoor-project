export default function Home() {
  return (
    <main className="min-h-screen flex items-center justify-center bg-green-100">
      <div className="bg-white p-8 rounded-xl shadow-lg">
        <h1 className="text-3xl font-bold text-green-700">Tailwind V4 Siap!</h1>
        <p className="text-gray-600 mt-2">OutdoorKu.id</p>
        <div className="mt-4 p-3 bg-gray-100 rounded text-sm">
          <p><strong>API URL:</strong> {process.env.NEXT_PUBLIC_API_URL}</p>
          <p><strong>Environment:</strong> {process.env.NEXT_PUBLIC_ENVIRONMENT || 'development'}</p>
        </div>
      </div>
    </main>
  );
}