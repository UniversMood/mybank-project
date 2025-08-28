import { useState, useEffect } from 'react'
import { operationService } from './services/api'
import OperationForm from './components/OperationForm'
import './App.css'

function App() {
  const [operations, setOperations] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)

  useEffect(() => {
    loadOperations()
  }, [])

  const loadOperations = async () => {
    try {
      const response = await operationService.getAll()
      setOperations(response.data)
    } catch (error) {
      setError('Error loading operations: ' + error.message)
    } finally {
      setLoading(false)
    }
  }

  if (loading) return <div className="p-8">Loading...</div>
  if (error) return <div className="p-8 text-red-600">{error}</div>

  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-slate-800 text-white p-4">
        <h1 className="text-2xl font-bold">MyBank</h1>
      </header>
      
      <main className="container mx-auto p-8 max-w-4xl">
        <OperationForm onOperationCreated={loadOperations} />
        
        <div className="bg-white rounded-lg shadow p-6">
          <h2 className="text-2xl font-bold mb-6">Your Expenses</h2>
          
          {operations.length === 0 ? (
            <p className="text-gray-500">No operations yet. Add your first expense above!</p>
          ) : (
            <div className="space-y-4">
              {operations.map((operation) => (
                <div key={operation.id} className="border-b pb-4 last:border-b-0">
                  <div className="flex justify-between items-center">
                    <div>
                      <h3 className="font-semibold">{operation.label}</h3>
                      <p className="text-sm text-gray-600">{operation.date}</p>
                    </div>
                    <div className="text-right">
                      <p className="font-bold text-lg">${operation.amount}</p>
                      <p className="text-sm text-gray-600">{operation.category}</p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </main>
    </div>
  )
}

export default App