<?php
class SystemTestListener implements \PHPUnit_Framework_TestListener
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->client = new \GuzzleHttp\Client();

        // optional: kill on every run
        $this->stopMockingAPI();

        try {
            $this->client->get(MOCK_API_URL);

        } catch (\Exception $e) {
            $this->startMockingAPI();
        }
    }

    protected function startMockingAPI()
    {
        shell_exec('osprey-mock-service -f res/api.raml -p 19999 >> /dev/null &');
        sleep(3);
    }

    protected function stopMockingAPI()
    {
        shell_exec('kill -9 $(ps aux | grep \'osprey-mock-service\' | awk \'{print $2}\')');
    }

    public function __destruct()
    {
        try {
            $this->client->get(MOCK_API_URL);
            $this->stopMockingAPI();

        } catch (\Exception $e) {
            // not running, ignore
        }
    }

    /**
     * An error occurred.
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    /**
     * A warning occurred.
     *
     * @param PHPUnit_Framework_Test    $test
     * @param PHPUnit_Framework_Warning $e
     * @param float                     $time
     *
     * @since Method available since Release 5.1.0
     */
    public function addWarning(PHPUnit_Framework_Test $test, PHPUnit_Framework_Warning $e, $time)
    {
    }

    /**
     * A failure occurred.
     *
     * @param PHPUnit_Framework_Test                 $test
     * @param PHPUnit_Framework_AssertionFailedError $e
     * @param float                                  $time
     */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
    }

    /**
     * Incomplete test.
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    /**
     * Skipped test.
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    /**
     * Risky test.
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception              $e
     * @param float                  $time
     */
    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    /**
     * A test started.
     *
     * @param PHPUnit_Framework_Test $test
     */
    public function startTest(PHPUnit_Framework_Test $test)
    {
    }

    /**
     * A test ended.
     *
     * @param PHPUnit_Framework_Test $test
     * @param float                  $time
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
    }

    /**
     * A test suite started.
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    /**
     * A test suite ended.
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }
}
