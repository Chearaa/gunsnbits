@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Impressum</h6>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <h5>Angaben gemäß §5 TMG</h5>
                                <p>
                                    Guns'n Bits e.V.<br/>
                                    Josef-Schwarz-Straße 14<br/>
                                    52379 Langerwehe
                                </p>
                                <h5>Postanschrift</h5>
                                <p>
                                    Guns'n Bits e.V.<br/>
                                    c/o Christian Röhl<br/>
                                    Waldorfer Straße 4<br/>
                                    50969 Köln<br/>
                                </p>
                                <h5>Kontakt</h5>
                                <p>
                                    <i class="fa fa-fw fa-phone"></i> 0221 / 936 732 96 <br />
				    <b>(Diese Nummer ist nicht für Reservierungen oder Fragen zur LAN gedacht. BITTE NICHT ANRUFEN. Schreiben Sie eine Email wenn Sie fragen haben)</b><br/>
                                    <i class="fa fa-fw fa-envelope"></i> <a href="mailto:info@gunsnbits.de">info@gunsnbits.de</a>
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <h5>Verantwortlich für den Inhalt<br/>(§55 Abs. 2 RStV)</h5>
                                <p>
                                    Guns'n Bits e.V.
                                </p>
                                <h5>Verein</h5>
                                <p>
                                    Vertreten durch: 2 Vorstandsmitglieder des Vereins<br/>
                                    Registernummer: 2609<br/>
                                    Eintragung beim Amtsgericht Düren
                                </p>
                                <h5>Bankverbindung</h5>
                                <p>
                                    Inhaber: {{ config('lanparty.accountholder') }}<br/>
                                    IBAN: {{ config('lanparty.iban') }}<br/>
                                    BIC: {{ config('lanparty.bic') }}<br/>
                                    Bank: Deutsche Skatbank
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Disclaimer</h6>
                    </div>
                    <div class="panel-body">

                        <h5>Haftung für Inhalte</h5>
                        <p>
                            Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
                        </p>
                        <h5>Haftung für Links</h5>
                        <p>
                            Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.
                        </p>
                        <h5>Urheberrecht</h5>
                        <p>
                            Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6>Datenschutzerklärung</h6>
                    </div>
                    <div class="panel-body">

                        <h5>Datenschutz</h5>
                        <p>
                            Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten möglich. Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder eMail-Adressen) erhoben werden, erfolgt dies, soweit möglich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdrückliche Zustimmung nicht an Dritte weitergegeben.<br/>
                            Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.<br/>
                            Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten durch Dritte zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit ausdrücklich widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor.
                        </p>
                        <h5>Auskunft, Löschung, Sperrung</h5>
                        <p>
                            Sie haben jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung sowie ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit über die im Impressum angegeben Adresse des Webseitenbetreibers an uns wenden.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection