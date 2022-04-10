import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faHome } from '@fortawesome/free-solid-svg-icons'
import { Breadcrumb } from '@themesberg/react-bootstrap'

class TestTables extends React.Component {
    render () {
        return (
            <React.Fragment>

                <div className="d-xl-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div className="d-block mb-4 mb-xl-0">
                        <Breadcrumb className="d-none d-md-inline-block" listProps={{ className: 'breadcrumb-dark breadcrumb-transparent' }}>
                            <Breadcrumb.Item><FontAwesomeIcon icon={faHome} /></Breadcrumb.Item>
                            <Breadcrumb.Item>Tables</Breadcrumb.Item>
                            <Breadcrumb.Item active>Data tables</Breadcrumb.Item>
                        </Breadcrumb>
                        <h4>Data tables</h4>
                        <p className="mb-0">
                            Dozens of reusable components built to provide buttons, alerts, popovers, and more.
                        </p>
                    </div>
                </div>
            </React.Fragment>
        )
    }
}

export default TestTables
