import React from 'react'
import { Link } from 'react-router-dom'

class About extends React.Component {
    render () {
        return (
            <main>
                <h2>About page :)</h2>
                <Link to="/">Invoices</Link>
                <Link to="/about">Expenses</Link>
                <Link to="/tables">Invoices</Link>
                <Link to="/testtables">Expenses</Link>
            </main>
        )
    }
}

export default About
