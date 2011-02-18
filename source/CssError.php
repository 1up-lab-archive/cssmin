<?php
/**
 * CssMin - A (simple) css minifier with benefits
 * 
 * --
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING 
 * BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * --
 *
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssError
	{
	/**
	 * Error message.
	 * 
	 * @var string
	 */
	public $Message = "";
	/**
	 * Source.
	 * 
	 * @var string
	 */
	public $Source = "";
	/**
	 * Constructor triggering the error.
	 * 
	 * @param string $message Error message
	 * @param string $source Corresponding line [optional]
	 * @return void
	 */
	public function __construct($message, $source = "")
		{
		$this->Message	= $message;
		$this->Source	= $source;
		}
	/**
	 * Returns the error as formatted string.
	 * 
	 * @return string
	 */	
	public function __toString()
		{
		return $this->Message . ":<p><code>" . $this->Source . "</code></p>";
		}
	}
?>