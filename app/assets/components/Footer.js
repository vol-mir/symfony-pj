import React from 'react'
import moment from 'moment-timezone'
import { Row, Col, Card } from '@themesberg/react-bootstrap'

class Footer extends React.Component {
    currentYear = moment().get('year')

    render () {
        return (
            <footer className="bg-white rounded shadow p-5 mb-4 mt-4">
                <Row>
                    <Col xs={12} lg={6} className="mb-4 mb-lg-0">
                        <p className="mb-0 text-center text-xl-left">
                            Copyright © 2019-{`${this.currentYear} `}
                            <Card.Link href="https://themesberg.com" target="_blank" className="text-blue text-decoration-none fw-normal">
                                Themesberg
                            </Card.Link>
                        </p>
                    </Col>
                    <Col xs={12} lg={6}>
                        <ul className="list-inline list-group-flush list-group-borderless text-center text-xl-right mb-0">
                            <li className="list-inline-item px-0 px-sm-2">
                                <Card.Link href="https://themesberg.com/about" target="_blank">
                                    About
                                </Card.Link>
                            </li>
                            <li className="list-inline-item px-0 px-sm-2">
                                <Card.Link href="https://themesberg.com/themes" target="_blank">
                                    Themes
                                </Card.Link>
                            </li>
                            <li className="list-inline-item px-0 px-sm-2">
                                <Card.Link href="https://themesberg.com/blog" target="_blank">
                                    Blog
                                </Card.Link>
                            </li>
                            <li className="list-inline-item px-0 px-sm-2">
                                <Card.Link href="https://themesberg.com/contact" target="_blank">
                                    Contact
                                </Card.Link>
                            </li>
                        </ul>
                    </Col>
                </Row>
            </footer>
        )
    }
}

export default Footer
